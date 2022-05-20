@extends($activeTemplate .'layouts.auth')
@section('content')

<div class="col-lg-6">
    <div class="register-form-area">
        <div class="register-logo-area text-center">
            <a href="{{ route('home') }}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
        </div>
        <div class="account-header text-center">
            <h2 class="title">@lang('Please Verify Your Mobile to Get Access')</h2>
            <p class="sub-title">@lang('Your Mobile'):  <strong>{{auth()->user()->mobile}}</strong></p>
        </div>


        <form action="{{route('user.verify_sms')}}" method="POST" class="register-form">
            @csrf

            <div class="form-group">
                <h5 class="col-md-12 mb-4 text-center">@lang('Enter Verification Code')</h5>
                <div id="phoneInput">

                    <div class="field-wrapper">
                        <div class=" phone">
                            <input type="text" name="sms_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="sms_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="sms_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="sms_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="sms_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="sms_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        </div>
                    </div>\
                </div>
            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" class="submit-btn">@lang('Submit')</button>
            </div>
            <div class="form-group">
                <p>@lang('If you don\'t get any verifaction code. Please') <a class="text-primary" href="{{route('user.send_verify_code')}}?type=phone" class="forget-pass"> @lang('Try Again')</a></p>
                @if ($errors->has('resend'))
                    <br/>
                    <small class="text-danger">{{ $errors->first('resend') }}</small>
                @endif
            </div>


        </form>
    </div>
</div>
@endsection
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.inputLettering.js') }}"></script>
@endpush
@push('style')
    <style>

        #phoneInput .field-wrapper {
            position: relative;
            text-align: center;
        }

        #phoneInput .form-group {
            min-width: 300px;
            width: 50%;
            margin: 4em auto;
            display: flex;
            border: 1px solid rgba(96, 100, 104, 0.3);
        }

        #phoneInput .letter {
            height: 50px;
            border-radius: 0;
            text-align: center;
            max-width: calc((100% / 10) - 1px);
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: calc(100% / 10);
            outline-style: none;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
            color: red;
            border: 1px solid #0e0d35;
        }

        #phoneInput .letter + .letter {
        }

        @media (max-width: 480px) {
            #phoneInput .field-wrapper {
                width: 100%;
            }

            #phoneInput .letter {
                font-size: 16px;
                padding: 2px 0;
                height: 35px;
            }
        }

    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
            });
        })(jQuery);
    </script>
@endpush
