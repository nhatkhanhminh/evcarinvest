@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-lg-4 mb-3">
                        <form action="" method="GET">
                            <div class="input-group has_append">
                                <input type="text" name="search" class="form-control" placeholder="@lang('Search')..." value="{{ request()->search ?? '' }}">
                                <div class="input-group-append">
                                    @if(request()->has('search'))
                                    <a href="{{ route('admin.miner.index') }}" class="btn btn--dark" >@lang('Clear')</a>
                                    @endif
                                    <button class="btn btn--success" id="search-btn" type="submit"><i class="la la-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Coin Code')</th>
                                <th>@lang('Plans')</th>
                                <th>@lang('Withdrawal Limit')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($miners as $miner)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ ($miner->currentPage-1) * $miner->perPage + $loop->iteration }}</td>
                                    <td data-label="@lang('Name')"> {{ $miner->name }} </td>
                                    <td data-label="@lang('Coin Code')"> {{ $miner->coin_code }} </td>
                                    <td data-label="@lang('Plans')"> {{ $miner->plans->count() }} </td>
                                    <td data-label="@lang('Withdrawal Limit')"> {{ getAmount($miner->min_withdraw_limit, 8) }} - {{ getAmount($miner->max_withdraw_limit, 8) }} </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.miner.plans', $miner->id) }}" class="icon-btn btn--info">@lang('View Plans')</a>
                                        <a href="javascript:void(0)"
                                            data-toggle="tooltip" data-placement="top"
                                            data-name="{{ $miner->name }}"
                                            data-id="{{ $miner->id }}"
                                            data-coin_code="{{ $miner->coin_code }}"
                                            data-min_withdraw_limit="{{ $miner->min_withdraw_limit }}"
                                            data-max_withdraw_limit="{{ $miner->max_withdraw_limit }}"
                                            class="icon-btn edit-btn">
                                            @lang('Edit')
                                        </a>
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

            </div>
            <div class="card-footer py-4">
                {{ $miners->appends(['search'=>request()->search ?? null])->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add miner')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.miner.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label>@lang('Miner Name')</label>
                        <input type="text" class="form-control" placeholder="@lang('Enter miner Name')" value="{{ old('name') }}" name="name" required/>
                        <small class="form-text text-muted"><i class="las la-info-circle"></i>@lang('Must be Unique')</small>
                    </div>

                    <div class="form-group">
                        <label>@lang('Coin Code')</label>
                        <input type="text" class="form-control" placeholder="@lang('Enter Coin Code')" value="{{ old('coin_code') }}" name="coin_code" required/>
                    </div>

                    <div class="form-group">
                        <label>@lang('Minimum Withdrawal Limit')</label>
                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Coin Code')" value="{{ old('minimum_withdrawal_limit') }}" name="minimum_withdrawal_limit" required/>
                    </div>

                    <div class="form-group">
                        <label>@lang('Minimum Withdrawal Limit')</label>
                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Coin Code')" value="{{ old('maximum_withdrawal_limit') }}" name="maximum_withdrawal_limit" required/>
                    </div>

                    <button type="submit" class="btn btn-block btn--primary">@lang('Add')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit miner')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label>@lang('Miner Name')</label>
                        <input type="text" class="form-control" placeholder="@lang('Enter Miner Name')" value="{{ old('name') }}" name="name" required/>
                        <small class="form-text text-muted"><i class="las la-info-circle"></i>@lang('Must be unique')</small>
                    </div>

                    <div class="form-group">
                        <label>@lang('Coin Code')</label>
                        <input type="text" class="form-control" placeholder="@lang('Enter Coin Code')" value="{{ old('coin_code') }}" name="coin_code" required/>
                    </div>

                    <div class="form-group">
                        <label>@lang('Minimum Withdrawal Limit')</label>
                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Coin Code')" value="{{ old('minimum_withdrawal_limit') }}" name="minimum_withdrawal_limit" required/>
                    </div>

                    <div class="form-group">
                        <label>@lang('Minimum Withdrawal Limit')</label>
                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Coin Code')" value="{{ old('maximum_withdrawal_limit') }}" name="maximum_withdrawal_limit" required/>
                    </div>


                    <button type="submit" class="btn btn-block btn--primary">@lang('Update')
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <button data-toggle="modal" data-target="#addModal" class="btn btn-sm btn--success box--shadow1 text--small">
        <i class="las la-plus"></i> @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        'use strict';
        (function($){
            $('#addModal, #editModal').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.edit-btn').on('click', function () {
                var modal       = $('#editModal');
                var form = document.getElementById('editForm');

                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=coin_code]').val($(this).data('coin_code'));
                modal.find('input[name=minimum_withdrawal_limit]').val($(this).data('min_withdraw_limit'));
                modal.find('input[name=maximum_withdrawal_limit]').val($(this).data('max_withdraw_limit'));
                form.action = '{{ route('admin.miner.update', '') }}' + '/' + $(this).data('id');
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
