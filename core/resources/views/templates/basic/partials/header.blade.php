<header class="header-section">
    <div class="header">
        <div class="header-top-area">
            <div class="container">
                <div class="header-top-content">
                    <div class="header-content d-flex flex-wrap justify-content-between align-items-center">
                        @php
                            $socials = getContent('social_icon.element');
                        @endphp
                        <div class="header-right-info">
                            <span class="first-info"><a href="tel:{{ $contactCaption->data_values->contact_number }}"><i class="fas fa-phone"></i>{{ $contactCaption->data_values->contact_number }}</a></span>
                        </div>
                        <div class="header-right-info">
                            <div class="header-action">
                                @guest
                                <a href="{{ route('user.register') }}" class="cmn-btn">@lang('Register')</a>
                                <a href="{{ route('user.login') }}" class="cmn-btn-active">@lang('Login')</a>
                                @else
                                    <a href="{{ route('user.home') }}" class="cmn-btn-active">@lang('Dashboard')</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0" >
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="site-logo"></a>

                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ml-auto mr-auto">
                                <li><a href="{{  route('home') }}"  class="active">@lang('Home')</a></li>
                                @if($pages->count() > 0)
                                    @foreach ($pages as $item)
                                        <li><a href="{{route('pages', ['slug'=> $item->slug ])}}">@php echo __($item->name) @endphp</a></li>
                                    @endforeach
                                @endif

                            </ul>
                            <select class="select-bar nic-select">
                                @foreach ($language as $lang)
                                    <option value="{{ $lang->code }}">@lang($lang->name)</option>
                                @endforeach
                            </select>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


<a href="#" class="scrollToTop"><i class="fa fa-angle-double-up"></i></a>


