@extends($activeTemplate .'layouts.auth')
@section('content')

<div class="col-lg-6">
    <div class="register-form-area">
        <div class="account-header text-center">
            <h2 class="title">@lang('Verify Reset Code')</h2>
            <p class="sub-title">@lang('A verification code has been sent to your email').</p>
        </div>
        <form action="{{ route('user.password.verify-code') }}" method="POST" class="register-form">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="email">@lang('Verification Code')</label>

                <div id="phoneInput">
                    <div class="field-wrapper">
                        <div class=" phone">
                            <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                            <input type="text" name="code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-12 form-group text-center">
                <button type="submit" class="submit-btn">@lang('Verify Code')</button>
            </div>

            <div class="account-header text-center">
                <p class="sub-title">
                    @lang('Please check including your Junk/Spam Folder. if not found, you can')  <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                </p>
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
        (function ($) {
            "use strict";
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
            });
        })(jQuery);
    </script>
@endpush
