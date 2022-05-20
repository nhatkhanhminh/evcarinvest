@extends($activeTemplate.'layouts.user')

@section('content')
<div class="dashboard-section ptb-80">
    <div class="checkout-section padding-bottom padding-top">
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
                            <p class="mt-3 mb-4 text-center">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</p>
                            <button type="button" class="cmn-btn btn-block" id="btn-confirm">@lang('Pay Now')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@push('script')

    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>
        'use strict';
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        (function($){
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });

        })(jQuery)

    </script>
@endpush
