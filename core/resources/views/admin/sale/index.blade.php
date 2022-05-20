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
                                <input type="text" name="search" class="form-control" placeholder="@lang('Type Order ID')" value="{{ request()->search ?? '' }}">
                                <div class="input-group-append">
                                    @if(request()->has('search'))
                                    <a href="{{ route('admin.sale.index') }}" class="btn btn--dark" >@lang('Clear')</a>
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
                                <th>@lang('Order ID')</th>
                                <th>@lang('Plan Title')</th>
                                <th>@lang('Miner')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Period')</th>
                                <th>@lang('Retun /Day')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($sales as $sale)
                                <tr>

                                    <td data-label="@lang('S.N.')"> {{ ($sale->currentPage-1) * $sale->perPage + $loop->iteration }}</td>
                                    <td data-label="@lang('Order ID')"> {{ __($sale->trx) }} </td>
                                    <td data-label="@lang('Plan Title')"> {{ __($sale->plan_details->title) }} </td>
                                    <td data-label="@lang('Miner')"> {{ __($sale->plan_details->miner) }} </td>
                                    <td data-label="@lang('Price')"> {{ getAmount($sale->amount) }} {{ $general->cur_text }} </td>
                                    <td data-label="@lang('Period')"> {{ $sale->plan_details->period }}</td>
                                    <td data-label="@lang('Return /Day')"> {{ getAmount($sale->min_return_per_day,8) }} - {{ getAmount($sale->max_return_per_day,8) }} <strong>{{ $sale->coin_code }}</strong> </td>

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
                {{ $sales->appends(['search'=>request()->search ?? null])->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>


@endsection

@push('breadcrumb-plugins')
    <button data-toggle="modal" data-target="#addModal" class="btn btn-sm btn--success box--shadow1 text--small"> <i class="las la-plus"></i> @lang('Add New')</button>
@endpush
