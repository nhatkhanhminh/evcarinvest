<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/x-icon" href="{{ getImage('assets/images/logoIcon/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ getImage('assets/images/logoIcon/favicon.png') }}"/>

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

@include('partials.seo')
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">

    <!-- lineawesome css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">

    <!-- nice-select css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/nice-select.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/animate.css')}}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/style.css')}}">
    @stack('style-lib')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset($activeTemplateTrue ."css/color.php?color=$general->base_color") }}">


    @stack('style')
</head>
<body>
    @include($activeTemplate.'partials.preloader')
@php
$contactCaption = getContent('contact_us.content', true);
@endphp
    <!-- header-section start -->
    <header class="header-section">
        <div class="header">
            <div class="header-bottom-area">
                <div class="container">
                    <div class="header-menu-content">
                        <nav class="navbar navbar-expand-lg p-0" >
                            <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="site-logo"></a>
                            <ul class="ml-auto">
                                <li>
                                    <select class="select-bar nic-select">
                                        @foreach ($language as $lang)
                                            <option value="{{ $lang->code }}">@lang($lang->name)</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-section end -->
    @php
        $breadcrumb    = getContent('breadcrumb.content',true);
    @endphp

    <section class="banner-section inner-banner-section bg-overlay-primary bg_img" data-background="{{ getImage('assets/images/frontend/breadcrumb/'.$breadcrumb->data_values->breadcrumb_image, '1950x600') }}">
        <div class="container">
            <div class="row justify-content-center align-items-center ml-b-30">
                <div class="col-lg-10 text-center mrb-30">
                    <div class="banner-content">
                        <h2 class="title">{{ $page_title }}</h2>
                        @if(!request()->routeIs('user.home'))
                        <div class="breadcrumb-area">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                    @stack('breadcrumb-plugins')
                                    <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
                                </ol>
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner-section end -->

    <section class="dashboard-section ptb-80">
        <div class="container">
            @include($activeTemplate.'user.partials.nav')

            @yield('content')

        </div>
    </section>


@include($activeTemplate.'partials.footer')


<!-- jquery -->
<script src="{{asset($activeTemplateTrue.'/js/jquery-3.3.1.min.js')}}"></script>
<!-- migarate-jquery -->
<script src="{{asset($activeTemplateTrue.'/js/jquery-migrate-3.0.0.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'/js/bootstrap.min.js')}}"></script>

<!-- nice-select js-->
<script src="{{asset($activeTemplateTrue.'/js/jquery.nice-select.js')}}"></script>

<!--chart js-->
<script src="{{asset($activeTemplateTrue.'/js/chart.js')}}"></script>

<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'/js/wow.min.js')}}"></script>
<!-- particle js -->
<script src="{{asset($activeTemplateTrue.'/js/particles.js')}}"></script>
<!-- main -->
<script src="{{asset($activeTemplateTrue.'/js/main.js')}}"></script>

@stack('script-lib')


@include($activeTemplate.'partials.notify')

@include('partials.plugins')


@stack('script')


<script>

    'use strict';
    (function($){
        $(document).on("change", ".select-bar", function() {
            window.location.href = "{{url('/')}}/change/"+$(this).val() ;
        });

        $('.select-bar').val('{{ session('lang') }}');
    })(jQuery)
</script>


</body>
</html>
