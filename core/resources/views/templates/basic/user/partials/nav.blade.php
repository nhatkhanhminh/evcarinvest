<div class="row">
    <div class="col-lg-12">
        <div class="dash-user-area">
            <div class="dash-left-user-area d-flex flex-wrap align-items-center">
                <div class="user-icon">


                    <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.auth()->user()->image ) }}" alt="@lang('user-profile')">

                </div>
                <div class="user-details d-flex flex-wrap align-items-center justify-content-between">
                    <h3 class="title">{{ auth()->user()->fullname }}</h3>
                    <ul class="dash-link">
                        <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>

                        <li class="menu_has_children"><a href="#0">@lang('Deposit')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.deposit') }}">@lang('Deposit Now')</a></li>
                                <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit Log')</a></li>
                            </ul>
                        </li>

                        <li class="menu_has_children"><a href="#0">@lang('Withdraw')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                                <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw Log')</a></li>
                            </ul>
                        </li>


                        <li class="menu_has_children"><a href="#0">@lang('Plan')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.plans') }}">@lang('Buy Plan')</a></li>
                                <li><a href="{{ route('user.plans.purchased') }}">@lang('Purchased Plans')</a></li>
                            </ul>
                        </li>

                        @if($general->referral_system)
                        <li class="menu_has_children"><a href="#0">@lang('Referral')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.referral') }}">@lang('Invite Friends')</a></li>
                                <li><a href="{{ route('user.referral.log') }}">@lang('Referral Bonus Logs')</a></li>
                            </ul>
                        </li>
                        @endif

                        <li class="menu_has_children"><a href="#0">@lang('My Account')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.profile-setting') }}">@lang('Profile')</a></li>
                                <li><a href="{{ route('user.wallets') }}">@lang('Wallets')</a></li>

                                <li><a href="{{ route('ticket') }}">@lang('Support Tickets')</a></li>
                                <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                <li><a href="{{ route('user.change-password') }}">@lang('Change Password')</a></li>
                                <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
