@extends($activeTemplate.'layouts.user')

@section('content')

<!-- pricing-section start -->
<div class="pricing-section">
    <ul class="nav nav-tabs pricing-tab-menu">
        @foreach ($miners as $item)
            <li class="nav-item">
                <a class="nav-link @if($loop->first) active show @endif" data-toggle="tab" href="#active_tab{{ $loop->iteration }}">{{ $item->name }}</a>
            </li>
        @endforeach

    </ul>
    <div class="tab-content">
        @foreach ($miners as $item)
        <div class="tab-pane fade @if($loop->first) active show @endif" id="active_tab{{ $loop->iteration }}">
            <div class="row justify-content-center ml-b-30 mrt-20">
                @foreach ($item->activePlans as $plan)
                    <div class="col-lg-3 col-md-6 col-sm-6 mrb-60">
                        <div class="pricing-item text-center">
                            <div class="pricing-inner">
                                <div class="pricing-header">
                                    <div class="pricing-icon">
                                        <i class="fas fa-smile"></i>
                                    </div>
                                    <h3 class="sub-title">{{ __($plan->title) }}</h3>
                                    <span class="pricing-border"></span>
                                    <h2 class="title">
                                        <span class="pricing-pre">{{ $general->cur_sym }}</span>{{ getAmount($plan->price) }}
                                        <span class="pricing-post">/ {{ $plan->period. ' '.$plan->periodUnitText }}</span>
                                    </h2>
                                </div>
                                <div class="pricing-body">
                                    <ul class="pricing-list">
                                        @foreach(json_decode($plan->features) as $feature)
                                        <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="pricing-btn-area">
                                        @guest
                                            <a href="{{ route('user.login') }}" class="cmn-btn-active">@lang('Buy Now')</a>
                                        @else
                                            <a href="javascript:void(0)" class="cmn-btn-active buy-plan" data-id="{{ $plan->id }}" data-title="{{ $plan->title }}" data-price="{{ getAmount($plan->price) }}">@lang('Buy Now')</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- pricing-section end -->

<!-- Modal -->
<div class="modal fade" id="buyPlanModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Buy Plan')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.plan.order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan_id">

                    <div class="form-row">
                        <div class="form-group col-12">
                        <label>@lang('Plan Title')</label>
                        <input type="text" class="form-control plan-title" readonly>
                        </div>

                        <div class="form-group col-12">
                        <label>@lang('Plan Price')</label>
                        <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                </div>
                            <input type="text" class="form-control plan-price" readonly>
                        </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="paymentMethod">@lang('Payment System')</label>
                            <select name="payment_method" id="paymentMethod" class="form-control nic-select">
                                <option value="" selected disabled>@lang('Select One')</option>
                                <option value="1">@lang('From Balance')</option>
                                <option value="2">@lang('Direct Payment')</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="cmn-btn btn-block">@lang('Buy Now')</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@endsection



@push('script')
<script>
'use strict';
(function($){

    $(document).on('click', '.buy-plan', function(){
        var modal = $('#buyPlanModal');
        modal.find('input[name=plan_id]').val($(this).data('id'));
        modal.find('.plan-title').val($(this).data('title'));
        modal.find('.plan-price').val($(this).data('price'));
        modal.modal('show');
    });
})(jQuery);
</script>
@endpush

