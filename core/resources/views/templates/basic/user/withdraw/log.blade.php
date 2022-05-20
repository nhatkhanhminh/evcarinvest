@extends($activeTemplate.'layouts.user')

@section('content')
<section class="order-section pd-b-80">
    <div class="row justify-content-center ml-b-30">
        <div class="col-lg-12 mrb-30">
            <div class="order-table-area">
                <table class="order-table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">@lang('Time')</th>
                            <th scope="col">@lang('Transaction ID')</th>
                            <th scope="col">@lang('Wallet')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($withdraws as $withdrawal)
                        <tr>
                            <td data-label="@lang('Time')">
                                {{showDateTime($withdrawal->created_at)}}
                            </td>
                            <td data-label="#@lang('Trx')">{{$withdrawal->trx}}</td>
                            <td data-label="@lang('Wallet')">{{ __($withdrawal->userCoinBalance->wallet) }}</td>
                            <td data-label="@lang('Amount')" class="text-right">
                                <strong>{{getAmount($withdrawal->amount, 8)}} {{ $withdrawal->userCoinBalance->coin_code }}</strong>
                            </td>

                            <td data-label="@lang('Status')">
                                @if($withdrawal->status == 0)
                                    <span class="badge badge-warning">@lang('Pending')</span>
                                @elseif($withdrawal->status == 1)
                                    <span class="badge badge-success">@lang('Completed')</span>

                                @elseif($withdrawal->status == 2)
                                    <span class="badge badge-danger">@lang('Rejected')</span>

                                @endif
                            </td>

                            <td data-label="@lang('Action')">
                                @if($withdrawal->status == 1)
                                    <button class="btn-success   approveBtn" data-admin_feedback="{{$withdrawal->admin_feedback}}"><i class="fas fa-desktop"></i></button>
                                @elseif($withdrawal->status == 2)
                                    <button class="btn-danger approveBtn" data-admin_feedback="{{$withdrawal->admin_feedback}}"><i class="fas fa-desktop"></i></button>
                                @else
                                <button class="btn-warning"><i class="fas fa-desktop"></i></button>
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{$withdraws->links()}}
        </div>
    </div>
</section>
    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="withdraw-detail"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');

                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);

    </script>
@endpush


@push('breadcrumb-plugins')
    <li class="breadcrumb-item active" aria-current="page">@lang('Withdraw Log')</li>
@endpush
