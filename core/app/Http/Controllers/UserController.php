<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use App\Miner;
use App\ReferralLog;
use App\Transaction;
use App\User;
use App\UserCoinBalance;
use App\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    public function home()
    {
        $page_title = 'Dashboard';

        $miners     = Miner::with(['userCoinBalances'=> function($q){
            return $q->where('user_id', auth()->id());
        }])->whereHas('userCoinBalances', function($q){
            return $q->where('user_id', auth()->id());
        })->get();

        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);
        $report['withdraw_month_amount'] = collect([]);

        $depositsMonth = Deposit::where('user_id', auth()->id())->whereYear('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
            ->orderBy('created_at')
            ->groupBy(DB::Raw("MONTH(created_at)"))->get();

        $depositsMonth->map(function ($aaa) use ($report) {
            $report['months']->push($aaa->months);
            $report['deposit_month_amount']->push(getAmount($aaa->depositAmount));
        });

        return view($this->activeTemplate . 'user.dashboard', compact('page_title', 'miners', 'report', 'depositsMonth'));
    }


    public function referral()
    {
        $general = GeneralSetting::first();

        if(!$general->referral_system){
            $notify[]=['error','Sorry, the referral system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $page_title = "Invite Friends";

        $referees = User::where('ref_by', auth()->id())->orderBy('id','desc')->with('paidOrders')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.referral.invite', compact('page_title', 'referees'));
    }

    public function referralLog(Type $var = null)
    {
        $general = GeneralSetting::first();

        if(!$general->referral_system){
            $notify[]=['error','Sorry, the referral system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $page_title = "Referral Bonus Logs";

        $logs = ReferralLog::where('user_id', auth()->id())->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.referral.logs', compact('page_title', 'logs'));
    }


    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate. 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => 'mimes:png,jpg,jpeg'
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            $size = imagePath()['profile']['user']['size'];
            $image = Image::make($image);
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
            $image->save($location);
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $data['withdrawMethod'] =   UserCoinBalance::where('user_id', auth()->user()->id)->with('miner')->get();
        $data['page_title']     =   "Withdraw Money";

        return view(activeTemplate() . 'user.withdraw.methods', $data);
    }
    public function withdrawStore(Request $request)
    {
        $wallet     = UserCoinBalance::where('id', $request->id)->with('miner')->first();
        $min_limit  = getAmount($wallet->miner->min_withdraw_limit, 8);
        $max_limit  = getAmount($wallet->miner->max_withdraw_limit, 8);
        $this->validate($request, [
            'id'        => 'required|exists:user_coin_balances,id',
            'amount'    => "required|numeric|min:$min_limit|max:$max_limit"
        ]);

        if($wallet->balance < $request->amount) {
            $notify[]=['error','You don\'t have the requested amount in your wallet'];
            return back()->withNotify($notify);
        }

        if(!$wallet->wallet){
            $notify[]=['error','You didn\'t provide any wallet address for this coin. Please update your wallet address'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();


        $withdraw                           = new Withdrawal();
        $withdraw->user_coin_balance_id     = $request->id;
        $withdraw->user_id                  = $user->id;
        $withdraw->amount                   = getAmount($request->amount);
        $withdraw->trx                      = getTrx();
        $withdraw->save();

        //Decrease the Balance
        $wallet->decrement('balance', $request->amount);

        $transaction                = new Transaction();
        $transaction->user_id       = $withdraw->user_id;
        $transaction->currency     = $wallet->coin_code;
        $transaction->amount        = getAmount($withdraw->amount);
        $transaction->post_balance  = getAmount($wallet->balance);
        $transaction->trx_type      = '-';
        $transaction->details       = getAmount($withdraw->amount) . ' ' . $wallet->coin_code . ' Withdraw Via Wallet Id: ' . $wallet->wallet;
        $transaction->trx           =  $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'wallet'        => $wallet->wallet,
            'post_balance'  => getAmount($wallet->balance),
            'amount'        => getAmount($withdraw->amount),
            'coin_code'     => $wallet->coin_code,
            'trx'           => $withdraw->trx

        ]);

        $notify[] = ['success', 'Withdrawal request successfully submitted'];

        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview')->withNotify($notify);
    }

    public function withdrawPreview()
    {
        $data['withdraw'] = Withdrawal::with('userCoinBalance','user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $data['page_title'] = "Withdraw Preview";
        return view($this->activeTemplate . 'user.withdraw.preview', $data);
    }

    public function withdrawLog()
    {
        $data['page_title'] = "Withdraw Log";
        $data['withdraws'] = Withdrawal::where('user_id', auth()->id())->with('userCoinBalance')->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', $data);
    }

    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {

            $user->tsc = null;
            $user->ts = 0;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->with($notify);
        }
    }

    public function wallets()
    {
        $data['page_title'] = "User Coin Wallets";
        $data['user']       = User::where('id', auth()->id())->with('coinBalances')->first();
        return view($this->activeTemplate. 'user.wallets', $data);
    }

    public function walletUpdate(Request $request)
    {
        $request->validate([
            "address" => 'required|array'
        ]);

        foreach ($request->address as $key => $value) {
            UserCoinBalance::where('coin_code', $key)->where('user_id', auth()->id())->update(['wallet'=>$value]);
        }

        $notify[]=['success','Wallet Address Updated Successfully'];
        return back()->withNotify($notify);
    }

}
