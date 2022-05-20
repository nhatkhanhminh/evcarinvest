@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Trx Number')</th>
                                @if(!request()->routeIs('admin.users.withdrawals'))
                                <th scope="col">@lang('Username')</th>
                                @endif
                                <th scope="col">@lang('Wallet')</th>
                                <th scope="col">@lang('Amount')</th>
                                @if(!request()->routeIs('admin.withdraw.pending'))
                                    <th scope="col">@lang('Status')</th>
                                @endif
                                @if($action)
                                <th>@lang('Action')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($withdrawals as $withdraw)
                                @php
                                    $details = ($withdraw->withdraw_information != null) ? json_encode($withdraw->withdraw_information) : null;
                                @endphp
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($withdraw->created_at) }}</td>
                                    <td data-label="@lang('Trx Number')" class="font-weight-bold">{{ strtoupper($withdraw->trx) }}</td>

                                    @if(!request()->routeIs('admin.users.withdrawals'))
                                    <td data-label="@lang('Username')">
                                        <a href="{{ route('admin.users.detail', $withdraw->user_id) }}">{{ @$withdraw->user->username }}</a>
                                    </td>
                                    @endif


                                    <td data-label="@lang('Wallet')">
                                        {{ __(@$withdraw->userCoinBalance->wallet) }}
                                    </td>
                                    <td data-label="@lang('Amount')" class="budget font-weight-bold">{{ getAmount($withdraw->amount, 8) }} {{__($withdraw->userCoinBalance->coin_code)}}</td>

                                    @if(!request()->routeIs('admin.withdraw.pending'))
                                        <td data-label="@lang('Status')">
                                            @if($withdraw->status == 0)
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                            @elseif($withdraw->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Approved')</span>
                                            @elseif($withdraw->status == 2)
                                                <span class="text--small badge font-weight-normal badge--danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                    @endif

                                    @if($action)

                                    <td data-label="@lang('Action')">
                                        @if($withdraw->status == 0)
                                            <button class="icon-btn btn--success approveBtn" data-toggle="tooltip" data-original-title="@lang('Approve')" data-id="{{ $withdraw->id }}" data-amount="{{ getAmount($withdraw->amount).' '.$withdraw->userCoinBalance->coin_code }}">
                                                <i class="las la-check"></i> @lang('Approve')
                                            </button>

                                            <button class="icon-btn btn--danger ml-1 rejectBtn" data-toggle="tooltip" data-original-title="@lang('Reject')" data-id="{{ $withdraw->id }}" >
                                                <i class="las fa-ban"></i> @lang('Reject')
                                            </button>
                                        @else
                                            @lang('Nohting to do')
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                <div class="card-footer py-4">
                    {{ $withdrawals->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve Withdrawal Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.withdraw.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <h4 class="mb-2">@lang('Have you Sent') <span class="font-weight-bold withdraw-amount text-success"></span>?</h4>
                        <p class="withdraw-detail"></p>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details. eg: Transaction number')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Approve')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Withdrawal Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.withdraw.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <strong>@lang('Reason of Rejection')</strong>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('breadcrumb-plugins')
    @if(!request()->routeIs('admin.users.withdrawals'))

        <form action="{{ route('admin.withdraw.search', $scope ?? str_replace('admin.withdraw.', '', request()->route()->getName())) }}"
            method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Withdrawal code/Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <form action="{{route('admin.withdraw.dateSearch',$scope ?? str_replace('admin.withdraw.', '', request()->route()->getName()))}}" method="GET" class="form-inline float-sm-right bg--white mr-0 mr-xl-2 mr-lg-0">
            <div class="input-group has_append">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="@lang('Min Date - Max date')" autocomplete="off" value="{{ @$dateSearch }}" readonly>
                <input type="hidden" name="method" value="{{ @$method->id }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush

@push('script')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
  <script>
        "use strict";
        (function ($) {
            // date picker
            if(!$('.datepicker-here').val()){
                $('.datepicker-here').datepicker();
            }


            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.modal('show');
            });

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });
        })(jQuery);
  </script>
@endpush
