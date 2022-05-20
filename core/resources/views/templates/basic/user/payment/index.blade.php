@extends($activeTemplate.'layouts.user')


@section('content')
<section class="dashboard-section ptb-80">
    <div class="container">
        <div class="row">
            @foreach($gatewayCurrency as $data)
                <div class="col-lg-3 col-md-3 mb-4">
                    <div class="card card-deposit rounded-0">
                        <h5 class="card-header text-center">{{__($data->name)}}
                        </h5>
                        <div class="card-body card-body-deposit">
                            <img src="{{$data->methodImage()}}" class="card-img-top" alt="{{__($data->name)}}" class="w-100">
                        </div>
                        <div class="card-footer rounded-0">
                            <a href="javascript:void(0)" data-id="{{$data->id}}" data-resource="{{$data}}"
                               data-min_amount="{{getAmount($data->min_amount)}}"
                               data-max_amount="{{getAmount($data->max_amount)}}"
                               data-base_symbol="{{$data->baseSymbol()}}"
                               data-fix_charge="{{getAmount($data->fixed_charge)}}"
                               data-percent_charge="{{getAmount($data->percent_charge)}}" class="cmn-btn btn-block payBtn" data-toggle="modal">
                                @lang('Pay Now')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="paymentModalLabel"></strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency" value="">
                            <input type="hidden" name="method_code" class="edit-method-code" value="">
                            <input type="hidden" name="is_payment" value="1">
                        </div>

                        <div class="form-group">
                          <label for="planTitle">@lang('Plan Title')</label>
                          <input type="text" id="planTitle" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>@lang('Payment Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text currency-addon">{{__($general->cur_text)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="cmn-btn btn-block">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop



@push('script')
    <script>
        "use strict";
        (function($){
            $('.payBtn').on('click', function () {
                var modal = $('#paymentModal');
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{__($general->cur_text)}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');
                var depositLimit = `@lang('Payment Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;

                $('.depositLimit').text(depositLimit);

                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;

                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                $('.currency-addon').text(baseSymbol);

                $('#planTitle').val('{{ $order->plan_details->title }}')
                $('#amount').val('{{ getAmount($order->amount) }}')

                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);

                modal.modal('show');
            });
        })(jQuery)

    </script>
@endpush
