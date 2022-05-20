<?php

namespace App\Http\Controllers;

use App\GatewayCurrency;
use App\GeneralSetting;
use App\Miner;
use App\Plan;
use Illuminate\Http\Request;
use App\Order;
use App\ReferralLog;
use App\Transaction;
use App\UserCoinBalance;

class OrderPlanController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function plans()
    {
        $data['page_title'] = "Plans";
        $data['miners']     = Miner::with('activePlans')->whereHas('activePlans')->get();
        return view($this->activeTemplate . 'user.plans.index', $data);
    }

    public function purchasedPlan()
    {
        $user               = auth()->user();
        $data['page_title'] = "My Purchased Plans";
        $data['orders']     = Order::where('user_id', $user->id)->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'user.plans.purchased', $data);
    }

    public function orderPlan(Request $request)
    {

        $request->validate([
            'plan_id'           => 'required|exists:plans,id',
            'payment_method'    => 'required|integer|between:1,2',
        ], [
            'payment_method.required' => 'Please Select a Payment System'
        ]);

        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->firstOrFail();

        $plan_details = [
            'title'         => $plan->title,
            'miner'         => $plan->miner->name,
            'speed'         => $plan->speed.' '.$plan->speedUnitText,
            'period'        => $plan->period.' '.$plan->periodUnitText,
            'period_value'  => $plan->period,
            'period_unit'   => $plan->period_unit,
        ];

        $user                       = auth()->user();
        $order                      = new Order;
        $order->trx                 = getTrx();
        $order->user_id             = $user->id;
        $order->plan_details        = $plan_details;
        $order->amount              = $plan->price;
        $order->min_return_per_day  = $plan->min_return_per_day;
        $order->max_return_per_day  = $plan->max_return_per_day??$plan->min_return_per_day;
        $order->coin_code           = $plan->miner->coin_code;

        $general = GeneralSetting::first();

        if($request->payment_method == 1){

            if($user->balance < $plan->price){
                $notify[]=['error','Sorry! You Don\'t Have Sufficent Balance To Buy This Plan'];
                return back()->withNotify($notify);
            }

            $period                 = totalPeriodInDay($plan->period, $plan->period_unit);
            $order->period          = $period;
            $order->period_remain   = $period;
            $order->status          = 1;
            $order->save();


            //Check If Exists
            $ucb            = UserCoinBalance::where('user_id', $user->id)->where('coin_code', $order->coin_code)->firstOrCreate([
                'user_id'       => $user->id,
                'coin_code'     => $order->coin_code
            ]);

            if($order){
                $user->balance -= $order->amount;
                $user->save();

                $referrer = $user->referrer;
                if($general->referral_system && $general->referral_bonus > 0 && $referrer){

                    $bonus_amonut = $order->amount * $general->referral_bonus / 100;
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

                $transaction                    = new Transaction();
                $transaction->user_id           = $order->user_id;
                $transaction->amount            = getAmount($order->amount);
                $transaction->charge            = 0;
                $transaction->post_balance      = $user->balance;
                $transaction->trx_type          = '+';
                $transaction->details           = 'Payment to Buy a Plan';
                $transaction->trx               =  $order->trx;
                $transaction->save();

                session()->put('trx', $order->trx);

                notify($user, 'PAYMENT_VIA_USER_BALANCE', [
                    'plan_title'        => $plan->title,
                    'amount'            => getAmount($order->amount),
                    'charge'            => 0,
                    'currency'          => $general->cur_text,
                    'method_currency'   => $general->cur_text,
                    'post_balance'      => $user->balance,
                    'method_name'       => $general->cur_text.' Balance',
                    'order_id'          => $order->trx,
                ]);

                $notify[] = ['success', 'Plan purchased successfully.'];

                return redirect()->route('user.plans.purchased')->withNotify($notify);
            }else{
                $notify[]=['error','Sorry something went wrong! We could\'nt complete your order. Please try again'];
                return back()->withNotify($notify);
            }
        }else{
            $order->status         = 0;
            $order->save();

            session()->put('trx', $order->trx);
            return redirect()->route('user.payment');
        }


        $page_title = 'Choose a Payment Method';

        return view($this->activeTemplate . 'user.payment.deposit', compact('page_title', 'plan'));
    }

    public function payment()
    {
        $trx = session()->get('trx');
        if($trx){

            $order = Order::where('trx', $trx)->first();

            $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', 1);
            })->with('method')->orderby('method_code')->get();

            $page_title = 'Payment Methods';

            return view($this->activeTemplate . 'user.payment.index', compact('gatewayCurrency', 'page_title', 'order'));
        }
        $notify[]=['error','Sorry! Something went wrong. Please Try Again'];
        return redirect('user.home')->withNotify($notify);
    }

}
