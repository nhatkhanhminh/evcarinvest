<?php

namespace App\Providers;

use App\GeneralSetting;
use App\Language;
use App\Page;
use App\Extension;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $activeTemplate = activeTemplate();

        $viewShare['general']           = GeneralSetting::first();
        $viewShare['activeTemplate']    = $activeTemplate;
        $viewShare['activeTemplateTrue']= activeTemplate(true);
        $viewShare['language']          = Language::all();
        $viewShare['pages']             = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count'           => \App\User::banned()->count(),
                'email_unverified_users_count' => \App\User::emailUnverified()->count(),
                'sms_unverified_users_count'   => \App\User::smsUnverified()->count(),
                'pending_ticket_count'         => \App\SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count'       => \App\Deposit::pending()->count(),
                'pending_withdraw_count'       => \App\Withdrawal::pending()->count(),
            ]);
        });

        view()->composer($activeTemplate.'sections.transaction', function ($view) {
            $view->with([
                'deposits'      => \App\Deposit::where('status',1)->with('user')->orderBy('id','DESC')->take(5)->get(),
                'withdraws'     => \App\Withdrawal::with('user')->orderBy('id','DESC')->take(5)->get()
            ]);
        });

        view()->composer($activeTemplate.'sections.calculate', function ($view) {
            $view->with([
                'miners'      => \App\Miner::with('plans')->whereHas('plans')->orderBy('name','ASC')->get(),
            ]);
        });

        view()->composer($activeTemplate.'sections.plan', function ($view) {
            $view->with([
                'miners'        => \App\Miner::with('activePlans')->whereHas('activePlans')->orderBy('name','ASC')->get(),
            ]);
        });


        view()->composer('partials.seo', function ($view) {
            $seo = \App\Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

    }
}
