@extends($activeTemplate .'layouts.auth')
@section('content')

<div class="col-lg-6">
    <div class="register-form-area">
        <div class="register-logo-area text-center">
            <a href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
        </div>
        <div class="account-header text-center">
            <h2 class="title">@lang('Reset Your Password')</h2>
            <p class="sub-title">@lang('Please enter your email to reset your password').</p>
        </div>
        <form method="POST" action="{{ route('user.password.email') }}" class="register-form">
            @csrf

            <div class="form-group col-lg-12">
                <label class="register-icon"><i class="fas fa-envelope"></i></label>
                <input id="email" type="email" class="form-control" placeholder="@lang('E-Mail Address')" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="col-lg-12 form-group text-center">
                <button type="submit" class="submit-btn">
                    @lang('Submit')
                </button>
            </div>
        </form>
        <div class="account-header text-center mt-1">
            <p class="sub-title">@lang('Go Back to') <a href="{{ route('user.login') }}">@lang('Login')</a></p>
        </div>
    </div>
</div>
@endsection
