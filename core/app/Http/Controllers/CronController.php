<?php
namespace App\Http\Controllers;

use App\GeneralSetting;
use Carbon\Carbon;
use App\Order;
use App\Transaction;
use App\UserCoinBalance;
class CronController extends Controller
{
    public function returnAmount()
    {
        $general            = GeneralSetting::first();
        $general->last_cron = Carbon::now()->toDateTimeString();
        $general->save();

        $orders = Order::where('status', 1)
                ->with('user')
                ->whereHas('user')
                ->where('last_paid', '<=', Carbon::now()->subHours(24)->toDateTimeString())
                ->get();

        if($orders->count() > 0){

            foreach ($orders as $order) {

                $return_amount   = rand($order->min_return_per_day*100000000, $order->max_return_per_day*100000000)/100000000;

                $ucb             = UserCoinBalance::where('user_id', $order->user_id)->where('coin_code', $order->coin_code)->first();

                if(!$ucb){
                    continue;
                }
                $ucb->balance += $return_amount;

                $ucb->save();

                $order->period_remain   -=1;
                $order->last_paid       = Carbon::now();
                $order->save();

                $transaction                = new Transaction();
                $transaction->user_id       = $order->user_id;
                $transaction->amount        = $return_amount;
                $transaction->post_balance  = getAmount($ucb->balance);
                $transaction->charge        = 0;
                $transaction->trx_type      = '+';
                $transaction->details       = 'Daily return amount for the plan '.$order->plan_details->title;
                $transaction->trx           = getTrx();
                $transaction->currency      = $order->coin_code;
                $transaction->save();

                if($order->period_remain == 0){

                    $order->status  = 2;
                    $order->save();

                }

            }
        }

        return 'Cron executed successfully';
    }
}
