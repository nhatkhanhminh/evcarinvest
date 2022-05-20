@extends($activeTemplate.'layouts.auth')
@section('content')
<div class="col-lg-10">
    <div class="register-form-area">
        <div class="register-logo-area text-center">
            <a href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
        </div>
        <div class="account-header text-center">
            <h2 class="title">@lang('Register Your Account Now')</h2>
            <p class="sub-title">@lang('Already Have An Account')? <a href="{{ route('user.login') }}">@lang('Login Now')</a></p>
        </div>

        <form action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();" class="register-form">
            @csrf
            <div class="row justify-content-center ml-b-20">

                @if($general->referral_system)
                    @if(session()->get('reference') != null)
                    <div class="col-lg-12 form-group">
                        <h5>@lang('You are referred by') {{session()->get('reference')}}</h5>
                        <input type="hidden" name="referBy" id="referenceBy" class="form-control" value="{{session()->get('reference')}}" readonly>
                    </div>
                    @endif
                @endif

                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-pen"></i></label>
                    <input id="firstname" type="text" class="form-control" name="firstname" placeholder="@lang('First Name')" value="{{ old('firstname') }}" required>
                </div>

                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-pen"></i></label>
                    <input id="lastname" type="text" class="form-control" placeholder="@lang('Last Name')" name="lastname" value="{{ old('lastname	') }}" required>
                </div>


                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-user"></i></label>
                    <input type="text" class="form-control" name="username" placeholder="@lang('Username')" value="{{ old('username') }}" required>
                </div>

                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-envelope"></i></label>
                    <input id="email" type="email" class="form-control" placeholder="@lang('E-Mail Address')" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="col-lg-6 form-group">
                    <div class="input-group country-select">
                        <div class="input-group-append">

                            <select name="country_code" class="input-group-text input--group--select pl-1">
                                @include('partials.country_code')
                            </select>

                        </div>
                        <input type="text" name="mobile" class="form-control" placeholder="@lang('Your Phone Number')">
                    </div>
                </div>

                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-globe"></i></label>
                    <input type="text" name="country" class="form-control" placeholder="@lang('Your Country')" readonly>
                </div>


                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-key"></i></label>
                    <input id="password" type="password" class="form-control" placeholder="@lang('Password')" name="password" required autocomplete="new-password">
                </div>

                <div class="col-lg-6 form-group">
                    <label class="register-icon"><i class="fas fa-key"></i></label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('Confirm Password')" required autocomplete="new-password">
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

                @php
                    $links = getContent('links.element');
                @endphp

                @if($links->count() > 0)
                <div class="col-lg-12 form-group text-center">
                    <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                        <div class="checkbox-item">
                            <input type="checkbox" id="c1" name="terms_condition" required>
                            <label for="c1">
                                @lang('I agree with the')
                                @foreach ($links as $item)
                                    <a class="text-primary" href="{{route('links', slug($item->data_values->title).'-'.$item->id)}}">@lang($item->data_values->title) </a>@if(!$loop->last),@endif
                                @endforeach

                            </label>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-12 form-group text-center">
                    <button type="submit" id="recaptcha" class="submit-btn">@lang('Register')</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection


@push('style')
<style type="text/css">
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script')
    <script>
      "use strict";
        (function($){
            var country = $('select[name=country_code] :selected').data('country');
            if(country){
                $('input[name=country]').val(country);
            }
            $('select[name=country_code]').on('change', function(){
                $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
            });
        })(jQuery)

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
