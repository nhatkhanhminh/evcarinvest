@extends($activeTemplate.'layouts.user')

@section('content')
        <div class="row justify-content-center">
            @forelse($withdrawMethod as $data)
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <h4 class="card-header bg-theme">{{ $data->coin_code }} @lang('Wallet')</h4>
                        <div class="card-body p-0">
                            <div class="p-3 border-bottom d-flex justify-content-between">
                                <span>
                                    @lang('Address')
                                </span>
                                <strong class="word--break fz--14 w-75 d-flex justify-content-end">
                                    @if($data->wallet) {{ $data->wallet }} @else <span class="text-danger">@lang('Please Update Your Wallet Address')</span> @endif
                                </strong>
                            </div>

                            <div class="p-3 border-bottom d-flex justify-content-between">
                                <span>
                                    @lang('Balance')
                                </span>
                                {{ getAmount($data->balance, 8).' '.$data->coin_code }}
                            </div>

                            <div class="p-3 d-flex border-bottom justify-content-between">
                                <span>
                                    @lang('Min Withdrawal Limit')
                                </span>
                                <span class="text-danger">
                                    {{ getAmount($data->miner->min_withdraw_limit, 8).' '.$data->coin_code }}
                                </span>
                            </div>

                            <div class="p-3 d-flex justify-content-between">
                                <span>
                                    @lang('Max Withdrawal Limit')
                                </span>
                                <span class="text-danger">
                                    {{ getAmount($data->miner->max_withdraw_limit, 8).' '.$data->coin_code }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center">
                            <a href="javascript:void(0)" data-id="{{$data->id}}"
                                data-resource="{{$data}}"
                                data-coin_code="{{__($data->coin_code)}}"
                                class="cmn-btn btn-block withdrawBtn text-center" data-toggle="modal" data-target="#exampleModal">
                                @lang('Withdraw Now')
                            </a>
                        </div>
                    </div>
                </div>
            @empty
            <div class="col-lg-12">
                <div class="alert alert-warning" role="alert">
                    <strong>@lang('You did\'t have any wallet yet.')</strong>
                </div>
            </div>
            @endforelse
        </div>
    <!-- Modal -->
    <div class="modal fade" id="withdrawModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('user.withdraw.money')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">

                                <div class="input-group-append">
                                    <span class="input-group-text currency-addon"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        'use strict';
        (function($){
            $('.withdrawBtn').on('click', function () {
                var modal = $('#withdrawModal');
                modal.find('.currency-addon').text($(this).data('coin_code'));
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show')
            });

        })(jQuery)

    </script>

@endpush


@push('breadcrumb-plugins')
<li class="breadcrumb-item active" aria-current="page">@lang('Withdraw')</li>
@endpush
