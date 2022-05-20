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

    <!-- nice-select css -->
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- nice-select css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/nice-select.css')}}">
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
    $content = getContent('banner.content',true);
@endphp

<section class="register-section bg-overlay-primary bg_img" data-background="{{ getImage('assets/images/frontend/banner/'.$content->data_values->banner_image, '1950x600') }}">

    <div class="container">
        <div class="row register-area justify-content-center align-items-center">

            @yield('content')

        </div>
    </div>

</section>

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

<!-- main -->
<script src="{{asset($activeTemplateTrue.'/js/main.js')}}"></script>


@stack('script-lib')



@include($activeTemplate.'partials.notify')

@php echo  analytics() @endphp


@stack('script')



</body>
</html>
