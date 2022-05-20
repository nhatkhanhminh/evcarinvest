@extends($activeTemplate.'layouts.user')

@push('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

@section('content')
<div class="dashboard-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <img src="{{ $deposit->gateway_currency()->methodImage() }}" class="card-img-top w-25" @lang('gateway-image')">
                        <h3 class="align-self-center cl-1">
                            @lang('Payment Confirm')
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{$data->url}}" method="{{$data->method}}" class="stripe-form">
                            <p class="mt-3 mb-4 text-center">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</p>
                            <script
                                src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            $('.stripe-form button[type="submit"]').addClass("cmn-btn btn-block").removeClass('stripe-button-el').html('@lang("Pay Now")');

        })(jQuery)

    </script>
@endpush


