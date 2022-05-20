@extends($activeTemplate.'layouts.user')

@section('content')

<div class="order-section pd-b-80">
    <div class="row justify-content-center ml-b-30">
        <div class="col-lg-12 mrb-30">
            <div class="order-table-area">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th scope="col">@lang('S.N.')</th>
                            <th scope="col">@lang('Plan')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Return /Day')</th>
                            <th scope="col">@lang('Total Days')</th>
                            <th scope="col">@lang('Remaining Days')</th>
                            <th scope="col"> @lang('Status')</th>
                            <th scope="col"> @lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($orders) >0)
                            @foreach($orders as $data)
                                <tr>
                                    <td data-label="@lang('S.N.')">{{$data->current_page-1 * $data->per_page + $loop->iteration }}</td>
                                    <td data-label="@lang('Plan')">{{$data->plan_details->title}}</td>
                                    <td data-label="@lang('Price')">
                                        <strong>{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Return /Day')" class="text-right">

                                        @if($data->min_return_per_day == $data->max_return_per_day)
                                        {{ getAmount($data->min_return_per_day,8) }}
                                        @else
                                        {{ getAmount($data->min_return_per_day, 8) .' - '.getAmount($data->max_return_per_day, 8) }}

                                        @endif
                                        {{ $data->coin_code }}
                                    </td>

                                    <td data-label="@lang('Total Days')">{{ $data->period }}</td>
                                    <td data-label="@lang('Remaining Days')">
                                        {{ $data->period_remain }}
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($data->status == 0)
                                            <span class="badge badge-warning">@lang('Pending')</span>
                                        @elseif($data->status == 1)
                                            <span class="badge badge-success">@lang('Approved')</span>
                                        @elseif($data->status == 2)
                                            <span class="badge badge-danger">@lang('Expired')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="cmn-btn viewBtn"
                                            data-date="{{ __(showDateTime($data->created_at, 'd M, Y'))  }}"
                                            data-trx="{{$data->trx}}"
                                            data-plan="{{$data->plan_details->title}}"
                                            data-miner="{{$data->plan_details->miner}}"
                                            data-speed="{{ $data->plan_details->speed }}"
                                            data-price="{{getAmount($data->amount)}} {{__($general->cur_text)}}"
                                            data-rpd="@if($data->min_return_per_day == $data->max_return_per_day)
                                            {{ getAmount($data->min_return_per_day,8) }}
                                            @else
                                            {{ getAmount($data->min_return_per_day,8) .' - '.getAmount($data->max_return_per_day,8) }}
                                            @endif
                                            {{ $data->coin_code }}"
                                            data-period = {{ $data->period }}
                                            data-period_r = {{ $data->period_remain }}
                                            >@lang('View')
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%"> @lang('No data found')!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{$orders->links()}}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header border-0 rounded-0">
                <h4 class="modal-title text-white">@lang('Purchased Plan Details')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group">
                    <li class="list-group-item border-0  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Purchased Date')</span>
                        <span class="p-date"></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Plan Title')</span>
                        <span class="plan-title"></span>
                    </li>
                    <li class="list-group-item  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Plan Price')</span>
                        <span class="plan-price"></span>
                    </li>

                    <li class="list-group-item  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Miner')</span>
                        <span class="miner-name"></span>
                    </li>

                    <li class="list-group-item  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Speed')</span>
                        <span class="speed"></span>
                    </li>

                    <li class="list-group-item  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Return /Day')</span>
                        <span class="plan-rpd"></span>
                    </li>

                    <li class="list-group-item  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Total Days')</span>
                        <span class="plan-period"></span>
                    </li>

                    <li class="list-group-item  d-flex justify-content-between">
                        <span class="font-weight-bold">@lang('Remaining Days')</span>
                        <span class="plan-period-r"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                modal.find('.p-date').text($(this).data('date'))
                modal.find('.plan-title').text($(this).data('plan'))
                modal.find('.plan-price').text($(this).data('price'))
                modal.find('.miner-name').text($(this).data('miner'))
                modal.find('.speed').text($(this).data('speed'))
                modal.find('.plan-rpd').text($(this).data('rpd'))
                modal.find('.plan-period').text($(this).data('period'))
                modal.find('.plan-period-r').text($(this).data('period_r'))
                modal.modal('show');
            })
        })(jQuery)
    </script>
@endpush


