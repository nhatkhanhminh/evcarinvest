<?php

namespace App\Http\Controllers\Gateway;

use App\GeneralSetting;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GatewayCurrency;
use App\Deposit;
use App\Order;
use App\ReferralLog;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\UserCoinBalance;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $page_title = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'page_title'));
    }

    public function depositInsert(Request $request)
    {
        $validation_rule = [
            'method_code'   => 'required',
            'currency'      => 'required',
            'is_payment'    => 'required|integer|between:0,1',
            'amount'        => 'required_if:is_payment, 0|gt:0'
        ];

        $request->validate($validation_rule, [
            'amount.required_if' => 'Please enter an amount'
        ]);

        if($request->is_payment){
            $trx    = session()->get('trx');
            $order  = Order::where('trx', $trx)->firstOrFail();
            if($order->payment_status == 1){
                $notify[] = ['error', 'You have already paid for this order'];
                return redirect()->route('plan')->withNotify($notify);
            }
            $is_payment = true;
            $amount     = $order->amount;

        }else{
            $amount  = $request->amount;
            $is_payment = false;
            $trx = getTrx();
        }


        $user = auth()->user();
        $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', 'Please Follow Deposit Limit'];
            return back()->withNotify($notify);
        }

        $charge         = getAmount($gate->fixed_charge + ($amount * $gate->percent_charge / 100));
        $payable        = getAmount($amount + $charge);
        $final_amo      = getAmount($payable * $gate->rate);

        $data                   = new Deposit();
        $data->user_id          = $user->id;
        $data->method_code      = $gate->method_code;
        $data->method_currency  = strtoupper($gate->currency);
        $data->is_payment       = $is_payment;
        $data->amount           = $amount;
        $data->charge           = $charge;
        $data->rate             = $gate->rate;
        $data->final_amo        = getAmount($final_amo);
        $data->btc_amo          = 0;
        $data->btc_wallet       = "";
        $data->trx              = $trx;
        $data->try              = 0;
        $data->status           = 0;
        $data->save();
        session()->put('Track', $data['trx']);

        return redirect()->route('user.deposit.preview');
    }


    public function depositPreview()
    {

        $track = session()->get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->firstOrFail();

        if (is_null($data)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($data->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        $page_title = 'Payment Preview';
        return view($this->activeTemplate . 'user.payment.preview', compact('data', 'page_title'));
    }


    public function depositConfirm()
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->with('gateway')->first();
        if (is_null($deposit)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($deposit->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $page_title = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'page_title', 'deposit'));
    }


    public static function userDataUpdate($trx)
    {
        $general    = GeneralSetting::first();
        $data   = Deposit::where('trx', $trx)->first();


        if ($data->status == 0) {
            $data->status = 1;
            $data->save();

            $user               = User::find($data->user_id);
            $transaction = new Transaction();
            $transaction->user_id       = $data->user_id;
            $transaction->amount        = $data->amount;
            $transaction->post_balance  = getAmount($user->balance);
            $transaction->charge        = getAmount($data->charge);
            $transaction->trx_type      = '+';
            $transaction->details       = 'Deposit Via ' . $data->gateway_currency()->name;
            $transaction->trx = $data->trx;
            $transaction->save();

            if(!$data->is_payment){
                $user->balance += $data->amount;
                $user->save();

                notify($user, 'DEPOSIT_COMPLETE', [
                    'method_name'       => $data->gateway_currency()->name,
                    'method_currency'   => $data->method_currency,
                    'method_amount'     => getAmount($data->final_amo),
                    'amount'            => getAmount($data->amount),
                    'charge'            => getAmount($data->charge),
                    'currency'          => $general->cur_text,
                    'rate'              => getAmount($data->rate),
                    'trx'               => $data->trx,
                    'post_balance'      => getAmount($user->balance)
                ]);

            }else{

                $transaction                = new Transaction();
                $transaction->user_id       = $data->user_id;
                $transaction->amount        = $data->amount;
                $transaction->post_balance  = getAmount($user->balance + $data->amount);
                $transaction->charge        = getAmount($data->charge);
                $transaction->trx_type      = '-';
                $transaction->details       = 'Payment Via ' . $data->gateway_currency()->name;
                $transaction->trx           = $data->trx;
                $transaction->save();

                $order                  = Order::where('trx', $trx)->first();
                $period                 = totalPeriodInDay($order->plan_details->period_value, $order->plan_details->period_unit);
                $order->status          = 1;
                $order->period          = $period;
                $order->period_remain   = $period;
                $order->save();

                //Check If Exists
                UserCoinBalance::where('user_id', $user->id)->where('coin_code', $order->coin_code)->firstOrCreate([
                    'user_id'       => $user->id,
                    'coin_code'     => $order->coin_code
                ]);

                $referrer       = $user->referrer;
                if($general->referral_system && $general->referral_bonus > 0 && $referrer){

                    $bonus_amonut   = $order->amount * $general->referral_bonus / 100;
                    $referrer->increment('balance', $bonus_amonut);

                    $refLog               = new ReferralLog();
                    $refLog->user_id      = $referrer->id;
                    $refLog->referee_id   = $user->id;
                    $refLog->amount       = $bonus_amonut;
                    $refLog->save();

                    $transaction                    = new Transaction();
                    $transaction->user_id           = $referrer->id;
                    $transaction->amount            = getAmount($bonus_amonut);
                    $transaction->charge            = 0;
                    $transaction->post_balance      = $referrer->balance;
                    $transaction->trx_type          = '+';
                    $transaction->details           = 'Received referral bonus on plan purchased by '. $user->username;
                    $transaction->trx               =  $order->trx;
                    $transaction->save();
                }

                notify($user, 'PAYMENT_COMPLETE', [
                    'plan_title'        => $order->plan_details->title,
                    'method_name'       => $data->gateway_currency()->name,
                    'method_currency'   => $data->method_currency,
                    'method_amount'     => getAmount($data->final_amo),
                    'amount'            => getAmount($data->amount),
                    'charge'            => getAmount($data->charge),
                    'currency'          => $general->cur_text,
                    'rate'              => getAmount($data->rate),
                    'order_id'          => $data->trx,
                    'post_balance'      => getAmount($user->balance)
                ]);
            }

        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {
            if($data->is_payment)
                $page_title = 'Payment Confirm';
            else
                $page_title = 'Deposit Confirm';

            $method = $data->gateway_currency();
            return view($this->activeTemplate . 'user.manual_payment.manual_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }

        $params = json_decode($data->gateway_currency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }


        $this->validate($request, $rules);


        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['deposit']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }



        $data->status = 2; // pending
        $data->save();

        $general = GeneralSetting::first();

        $short_code = [
            'method_name' => $data->gateway_currency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => getAmount($data->final_amo),
            'amount' => getAmount($data->amount),
            'charge' => getAmount($data->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($data->rate),
            'trx' => $data->trx
        ];

        if($data->is_payment){
            notify($data->user, 'PAYMENT_REQUEST', $short_code);
            $notify[] = ['success', 'Your payment request has been taken.'];

        }else{
            notify($data->user, 'DEPOSIT_REQUEST', $short_code);
            $notify[] = ['success', 'Your deposit request has been taken.'];
        }


        return redirect()->route('user.deposit.history')->withNotify($notify);
    }


}
