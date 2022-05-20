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
                                <input type="text" name="search" class="form-control" placeholder="@lang('Type Plan Title / Miner Name')" value="{{ request()->search ?? '' }}">
                                <div class="input-group-append">
                                    @if(request()->has('search'))
                                    <a href="{{ route('admin.plan.index') }}" class="btn btn--dark" >@lang('Clear')</a>
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
                                <th>@lang('Title')</th>
                                <th>@lang('Miner')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Speed')</th>
                                <th>@lang('Period')</th>
                                <th>@lang('Retun /Day')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($plans as $plan)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ ($plan->currentPage-1) * $plan->perPage + $loop->iteration }}</td>
                                    <td data-label="@lang('Title')"> {{ __($plan->title) }} </td>
                                    <td data-label="@lang('Miner')"> {{ __($plan->miner->name) }} </td>
                                    <td data-label="@lang('Price')" class="text-left"> {{ getAmount($plan->price) }} {{ $general->cur_text }}</td>
                                    <td data-label="@lang('Speed')"> {{ $plan->speed }} {{ $plan->speedUnitText}} </td>
                                    <td data-label="@lang('Period')"> {{ $plan->period }} {{ $plan->periodUnitText}}</td>
                                    <td data-label="@lang('Return /Day')" class="text-left"> {{ $plan->returnPerDay }}</td>
                                    <td data-label="@lang('Status')"> <span class="text--small badge @if($plan->status) badge--success @else badge--danger @endif font-weight-normal">@if($plan->status) @lang('Active') @else @lang('Inactive') @endif </span> </td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" data-plan="{{ $plan }}" data-toggle="modal" class="icon-btn edit-btn">
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
                {{ $plans->appends(['search'=>request()->search ?? null])->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add plan')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.plan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Title')</label>
                            <input type="text" class="form-control" placeholder="@lang('Enter Plan Title')" name="title" required  />
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Miner')</label>
                            <select class="form-control" name="miner" >
                                <option value="">@lang('Select One')</option>
                                @foreach ($miners as $miner)
                                    <option data-coin_code={{ $miner->coin_code }} value="{{ $miner->id }}"> {{ $miner->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Price')</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">{{ $general->cur_sym }}</label>
                                </div>
                                <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Price')" name="price" required/>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Return Amount Type')</label>
                            <select class="custom-select input-group-text" name="return_type">
                                <option value="1">@lang('Fixed')</option>
                                <option value="2">@lang('Random')</option>
                            </select>
                        </div>


                        <div class="col-12 return-type-wrapper">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Return Amount /Day')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="return_per_day" required/>
                                    <div class="input-group-append">
                                        <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Speed')</label>
                            <div class="input-group">
                                <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Speed Value')" name="speed" required/>
                                <div class="input-group-append">
                                    <select class="custom-select input-group-text" name="speed_unit">
                                        <option value="0">@lang('hash/s')</option>
                                        <option value="1">@lang('Khash/s')</option>
                                        <option value="2" selected>@lang('Mhash/s')</option>
                                        <option value="3">@lang('Ghash/s')</option>
                                        <option value="4">@lang('Thash/s')</option>
                                        <option value="5">@lang('Phash/s')</option>
                                        <option value="6">@lang('Ehash/s')</option>
                                        <option value="7">@lang('Zhash/s')</option>
                                        <option value="8">@lang('Yhash/s')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Period')</label>
                            <div class="input-group">
                                <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Period Value')" name="period"  required/>
                                <div class="input-group-append">
                                    <select class="custom-select input-group-text" name="period_unit">
                                        <option value="0">@lang('Day')</option>
                                        <option value="1">@lang('Month')</option>
                                        <option value="2">@lang('Year')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">@lang('Features')</label>
                        <select class="form-control select2-multi-select" name="features[]" multiple>
                          <option value="">@lang('Select One')</option>
                          @foreach ($features as $feature)
                              <option value="{{ $feature->name }}"> {{ $feature->name }}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-bold">@lang('Description')</label>
                      <textarea class="form-control" name="description" rows="3">{{ old('descripiton') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status" checked>
                    </div>

                    <button type="submit" class="btn btn-block btn--primary">@lang('Add')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Plan')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Title')</label>
                            <input type="text" class="form-control" placeholder="@lang('Enter Plan Title')" name="title" required  />
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Miner')</label>
                            <select class="form-control" name="miner" >
                                <option value="">@lang('Select One')</option>
                                @foreach ($miners as $miner)
                                    <option data-coin_code={{ $miner->coin_code }} value="{{ $miner->id }}"> {{ $miner->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Price')</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">{{ $general->cur_sym }}</label>
                                </div>
                                <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Price')" name="price" required/>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Return Amount Type')</label>
                            <select class="custom-select input-group-text" name="return_type">
                                <option value="1">@lang('Fixed')</option>
                                <option value="2">@lang('Random')</option>
                            </select>
                        </div>


                        <div class="col-12 return-type-wrapper">

                        </div>


                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Speed')</label>
                            <div class="input-group">
                                <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Speed Value')" name="speed" required/>
                                <div class="input-group-append">
                                    <select class="custom-select input-group-text" name="speed_unit">
                                        <option value="0">@lang('hash/s')</option>
                                        <option value="1">@lang('Khash/s')</option>
                                        <option value="2" selected>@lang('Mhash/s')</option>
                                        <option value="3">@lang('Ghash/s')</option>
                                        <option value="4">@lang('Thash/s')</option>
                                        <option value="5">@lang('Phash/s')</option>
                                        <option value="6">@lang('Ehash/s')</option>
                                        <option value="7">@lang('Zhash/s')</option>
                                        <option value="8">@lang('Yhash/s')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold">@lang('Period')</label>
                            <div class="input-group">
                                <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Period Value')" name="period"  required/>
                                <div class="input-group-append">
                                    <select class="custom-select input-group-text" name="period_unit">
                                        <option value="0">@lang('Day')</option>
                                        <option value="1">@lang('Month')</option>
                                        <option value="2">@lang('Year')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">@lang('Features')</label>
                        <select class="form-control select2-multi-select" name="features[]" multiple>
                          <option value="">@lang('Select One')</option>
                          @foreach ($features as $feature)
                              <option value="{{ $feature->name }}"> {{ $feature->name }}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-bold">@lang('Description')</label>
                      <textarea class="form-control" name="description" rows="3">{{ old('descripiton') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status" checked>
                    </div>

                    <button type="submit" class="btn btn-block btn--primary">@lang('Update')</button>
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

            $('.edit-btn').on('click', function () {
                var modal       = $('#editModal');
                var plan        = $(this).data('plan');
                var form = document.getElementById('editForm');

                modal.find('input[name=title]').val(plan.title);
                modal.find('input[name=price]').val(parseFloat(plan.price));
                modal.find('.rpd_cur_sym').text(plan.miner.coin_code);
                modal.find('select[name=miner]').val(plan.miner_id);
                modal.find('input[name=speed]').val(plan.speed);
                modal.find('select[name=speed_unit]').val(plan.speed_unit);

                modal.find('input[name=period]').val(plan.period);
                modal.find('select[name=period_unit]').val(plan.period_unit);


                if(!plan.max_return_per_day){
                    modal.find('select[name=return_type]').val(1);
                    modal.find('.return-type-wrapper').html(`
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Return Amount /Day')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="return_per_day" required/>
                                    <div class="input-group-append">
                                        <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                    </div>
                                </div>
                            </div>
                    `)
                    modal.find('input[name=return_per_day]').val(parseFloat(plan.min_return_per_day));

                }else{
                    modal.find('select[name=return_type]').val(2);
                    modal.find('.return-type-wrapper').html(`<div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="font-weight-bold">@lang('Minimum Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="min_return_per_day" required/>
                                        <div class="input-group-append">
                                            <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label class="font-weight-bold">@lang('Maximum Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="max_return_per_day" required/>
                                        <div class="input-group-append">
                                            <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>`)

                    modal.find('input[name=min_return_per_day]').val(parseFloat(plan.min_return_per_day));
                    modal.find('input[name=max_return_per_day]').val(parseFloat(plan.max_return_per_day));
                }

                var coinCode = modal.find('select[name=miner]').find(':selected').attr('data-coin_code');
                modal.find('.rpd_cur_sym').text(coinCode);

                if(plan.status == 0){
                    modal.find('.toggle').addClass('btn--danger off').removeClass('btn--success');
                    modal.find('input[name="status"]').prop('checked', false);
                }else{
                    modal.find('.toggle').removeClass('btn--danger off').addClass('btn--success');
                    modal.find('input[name="status"]').prop('checked', true);
                }

                modal.find('select[name="features[]"]').val(JSON.parse(plan.features));

                modal.find('.select2-basic, .select2-multi-select').select2({
                    dropdownParent: modal
                });

                modal.find('textarea[name=description]').val(plan.description);


                form.action = '{{ route('admin.plan.update', '') }}' + '/' +plan.id;

                modal.modal('show');
            });



            $(document).on('change', 'select[name=miner]', function(){
                var coinCode = $(this).find(':selected').attr('data-coin_code');
                $(this).parents('.modal-body').find('.rpd_cur_sym').text(coinCode);
            });

            $(document).on('change', 'select[name=return_type]', function(){
                if($(this).val() == 2){
                    $(this).parents('.modal-body').find('.return-type-wrapper').html(`<div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="font-weight-bold">@lang('Minimum Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="min_return_per_day" required/>
                                        <div class="input-group-append">
                                            <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label class="font-weight-bold">@lang('Maximum Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="max_return_per_day" required/>
                                        <div class="input-group-append">
                                            <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>`).hide('slow').show('slow');
                }else{
                    $(this).parents('.modal-body').find('.return-type-wrapper').html(`
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control numeric-validation" placeholder="@lang('Enter Return Per Day')" name="return_per_day" required/>
                                        <div class="input-group-append">
                                            <label class="input-group-text rpd_cur_sym">{{ $general->cur_text }}</label>
                                        </div>
                                    </div>
                                </div>
                            `).hide('slow').show('slow');
                }
                var coinCode = $(this).parents('.modal-body').find('select[name=miner]').find(':selected').attr('data-coin_code');
                $(this).parents('.modal-body').find('.rpd_cur_sym').text(coinCode);
            });
        })(jQuery)
    </script>
@endpush
