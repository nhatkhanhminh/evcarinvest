@extends($activeTemplate .'layouts.auth')
@section('content')

<div class="col-lg-6">
    <div class="register-form-area">
        <div class="account-header text-center">
            <h2 class="title">@lang('Reset Your Password')</h2>
        </div>

        <form method="POST" action="{{ route('user.password.update') }}" class="register-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="col-lg-12 form-group">
                <label class="register-icon"><i class="fas fa-key"></i></label>
                <input id="password" type="password" class="form-control" placeholder="@lang('Password')" name="password" required autocomplete="new-password">
            </div>

            <div class="col-lg-12 form-group">
                <label class="register-icon"><i class="fas fa-key"></i></label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('Confirm Password')" required autocomplete="new-password">
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
