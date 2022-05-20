<?php

namespace App\Http\Controllers\Admin;

use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use App\UserCoinBalance;
use App\WithdrawMethod;
use App\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $page_title = 'Pending Withdrawals';
        $withdrawals = Withdrawal::where('status', 0)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        $type = 'pending';
        $action = true;
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','type', 'action'));
    }
    public function approved()
    {
        $page_title = 'Approved Withdrawals';
        $withdrawals = Withdrawal::where('status', 1)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        $type = 'approved';
        $action = false;
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','type', 'action'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::where('status', 2)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        $type = 'rejected';
        $action = false;
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','type', 'action'));
    }

    public function log()
    {
        $page_title = 'Withdrawals Log';
        $withdrawals = Withdrawal::with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        $action = true;
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'action'));
    }


    public function logViaMethod($method_id,$type = null){
        $method = UserCoinBalance::findOrFail($method_id);
        $action = true;
        if ($type == 'approved') {
            $action = false;
            $page_title = 'Approved Withdrawal Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 1)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        }elseif($type == 'rejected'){
            $action = false;
            $page_title = 'Rejected Withdrawals Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 3)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());

        }elseif($type == 'pending'){
            $page_title = 'Pending Withdrawals Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 2)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        }else{
            $page_title = 'Withdrawals Via '.$method->name;
            $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','userCoinBalance'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'action'));
    }


    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $withdrawals = Withdrawal::with(['user', 'userCoinBalance'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like',"%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like',"%$search%");
                });
        });

        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 0);
                break;
            case 'approved':
                $page_title .= 'Approved Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 2);
                break;
            case 'log':
                $page_title .= 'Withdrawal History Search';
                break;
        }

        $withdrawals = $withdrawals->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        $action = true;

        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'search', 'scope', 'withdrawals', 'action'));
    }

    public function dateSearch(Request $request,$scope){
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);


        $notify[]=['error','Invalid Date'];

        if(!(@strtotime($date[0]))){
            return back()->withNotify($notify);
        }

        if(isset($date[1]) && !strtotime($date[1])){
            return back()->withNotify($notify);
        }

        $start = @$date[0];
        $end = @$date[1];
        if ($start) {
            $withdrawals = Withdrawal::where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<=',Carbon::parse($start)->addDays(1));
        }
        if($end){
            $withdrawals = Withdrawal::where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<',Carbon::parse($end));
        }
        if ($request->method) {
            $method = WithdrawMethod::findOrFail($request->method);
            $withdrawals = $withdrawals->where('method_id',$method->id);
        }

        switch ($scope) {
            case 'pending':
                $withdrawals = $withdrawals->where('status', 0);
                break;
            case 'approved':
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $withdrawals = $withdrawals->where('status', 2);
                break;
        }

        $title = $scope!='log'?ucfirst($scope).' ':'';

        $withdrawals = $withdrawals->with(['user', 'userCoinBalance'])->paginate(getPaginate());
        $page_title =  $title. 'Withdraw Logs Between '.showDateTime($start, 'd M, Y') .' to '.showDateTime($end, 'd M, Y');
        $empty_message = 'No Withdrawals Found';
        $dateSearch = $search;
        $action = true;
        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'dateSearch', 'withdrawals','scope', 'action'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status', 0)->with('user', 'userCoinBalance')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $general = GeneralSetting::first();

        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'wallet'        => $withdraw->userCoinBalance->wallet,
            'amount'        => getAmount($withdraw->amount),
            'coin_code'     => $withdraw->userCoinBalance->coin_code,
            'trx'           => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal Marked as Approved.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $general    = GeneralSetting::first();
        $withdraw   = Withdrawal::where('id', $request->id)->with('user', 'userCoinBalance')->where('status',0)->firstOrFail();

        $wallet     = $withdraw->userCoinBalance;
        $user       = User::find($withdraw->user_id);

        $withdraw->status = 2;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $wallet->increment('balance', $withdraw->amount);

        $transaction                = new Transaction();
        $transaction->user_id       = $withdraw->user_id;
        $transaction->amount        = $withdraw->amount;
        $transaction->post_balance  = getAmount($wallet->balance - $withdraw->amount);
        $transaction->charge        = 0;
        $transaction->trx_type      = '+';
        $transaction->details       = getAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from Withdrawal Rejection';
        $transaction->trx           = $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REJECT', [
            'wallet'        => $wallet->wallet,
            'amount'        => getAmount($withdraw->amount),
            'coin_code'     => $wallet->coin_code,
            'trx'           => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal has been rejected.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

}
