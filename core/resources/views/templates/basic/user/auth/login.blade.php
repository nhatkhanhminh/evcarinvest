@extends($activeTemplate.'layouts.auth')
@section('content')
<div class="col-lg-6">
    <div class="register-form-area">
        <div class="register-logo-area text-center">
            <a href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
        </div>
        @if (Route::has('user.register'))
        <div class="account-header text-center">
            <h2 class="title">@lang('Login To Your Account Now')</h2>
            <p class="sub-title">@lang('Don\'t Have An Account')? <a href="{{ route('user.register') }}">@lang('Create Now')</a></p>
        </div>
        @endif
        <form method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();" class="register-form">
            @csrf
            <div class="row justify-content-center ml-b-20">
                <div class="col-lg-12 form-group">
                    <label class="register-icon"><i class="fas fa-user"></i></label>
                    <input type="text" class="form-control" name="username" placeholder="@lang('Username')" value="{{ old('username') }}" required>
                </div>

                <div class="col-lg-12 form-group">
                    <label class="register-icon"><i class="fas fa-key"></i></label>
                    <input id="password" type="password" class="form-control" placeholder="@lang('Password')" name="password" required autocomplete="new-password">
                </div>



                @php
                    $captcha = recaptcha();
                @endphp
                @if($captcha)
                <div class="col-lg-12 form-group">
                    @php echo recaptcha() @endphp
                </div>
                @endif


                @php
                    $captcha = getCustomCaptcha($height = 46, $width = '100%', $bgcolor = '#003');
                    @endphp

                @if($captcha)
                <div class="col-lg-12 form-group">
                    <label class="register-icon"><i class="fas fa-pen"></i></label>
                    <input type="text" name="captcha" placeholder="@lang('Enter The Code Below')" class="form-control" autocomplete="off">
                </div>
                <div class="col-lg-12 form-group">
                    @php echo  $captcha; @endphp
                </div>
                @endif

                @if (Route::has('user.password.request'))
                <div class="col-lg-12 form-group text-center">
                    <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                        <div class="checkbox-item">
                            <label class="forgot-password"><a href="{{route('user.password.request')}}">@lang('Forgot Password')?</a></label>
                        </div>
                    </div>
                </div>
                @endif


                <div class="col-lg-12 form-group text-center">
                    <button type="submit" id="recaptcha" class="submit-btn">@lang('Login')</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }

            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
