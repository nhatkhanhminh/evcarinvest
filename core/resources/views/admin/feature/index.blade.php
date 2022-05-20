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
                                    <a href="{{ route('admin.feature.index') }}" class="btn btn--dark" >@lang('Clear')</a>
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
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($features as $feature)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ ($feature->currentPage-1) * $feature->perPage + $loop->iteration }}</td>
                                    <td data-label="@lang('Name')"> {{ $feature->name }} </td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)"
                                            data-name="{{ $feature->name }}" data-id="{{ $feature->id }}" data-toggle="modal"
                                            class="icon-btn edit-btn">
                                            @lang('Edit')
                                        </a>

                                        <button class="ml-1 icon-btn btn--danger deleteBtn" type="button" data-id="{{ $feature->id }}">@lang('Delete')</button>
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
                {{ $features->appends(['search'=>request()->search ?? null])->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Feature')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.feature.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label>@lang('Feature Name')</label>
                        <input type="text" class="form-control" placeholder="@lang('Enter Feature Name')" value="{{ old('name') }}" name="name" required/>
                        <small class="form-text text-muted"><i class="las la-info-circle"></i>@lang('Must be Unique')</small>
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
                <h5 class="modal-title">@lang('Edit Feature')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Feature Name')</label>
                        <input type="text" class="form-control" placeholder="@lang('Enter Feature Name')" value="{{ old('name') }}" name="name" required/>
                        <small class="form-text text-muted"><i class="las la-info-circle"></i>@lang('Must be unique')</small>
                    </div>

                    <button type="submit" class="btn btn-block btn--primary">@lang('Update')
                </div>
            </form>
        </div>
    </div>
</div>

 <!-- Removal Modal -->
 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    @lang('Are you sure to delete this Feature?')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <button data-toggle="modal" data-target="#addModal" class="btn btn-sm btn--success box--shadow1 text--small"> <i class="las la-plus"></i> @lang('Add New')</button>
@endpush

@push('script')
    <script>
        'use strict';
        (function($){
            $('#addModal, #editModal').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $(document).on('click', '.deleteBtn', function () {
                var modal = $('#deleteModal');
                var id  = $(this).data('id');
                var link  = `{{ route('admin.feature.remove', '') }}/${id}`;
                modal.find('form').attr('action', link);
                modal.modal('show');
            });

            $('.edit-btn').on('click', function () {
                var modal       = $('#editModal');
                modal.find('input[name=name]').val($(this).data('name'));
                var form = document.getElementById('editForm');
                form.action = '{{ route('admin.feature.update', '') }}' + '/' +$(this).data('id');
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
