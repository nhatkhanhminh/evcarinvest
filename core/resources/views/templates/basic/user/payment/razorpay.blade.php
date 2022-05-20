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
                        <form action="{{$data->url}}" method="{{$data->method}}">

                            <p class="mt-3 mb-4 text-center">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</p>

                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >

                            </script>

                            <input type="hidden" custom="{{$data->custom}}" name="hidden">

                        </form>

                    </div>
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
            $('input[type="submit"]').addClass("cmn-btn text-center btn-block");
        })(jQuery)
    </script>
@endpush


