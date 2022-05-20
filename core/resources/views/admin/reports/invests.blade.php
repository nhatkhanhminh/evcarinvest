@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('S.N.')</th>
                                <th scope="col">@lang('Plan')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Return /Day')</th>
                                <th scope="col">@lang('Total Days')</th>
                                <th scope="col">@lang('Remaining Days')</th>
                                <th scope="col"> @lang('Status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($invests as $data)
                            <tr>
                                <td data-label="@lang('S.N.')">{{$data->current_page-1 * $data->per_page + $loop->iteration }}</td>
                                <td data-label="@lang('Plan')">{{$data->plan_details->title}}</td>
                                <td data-label="@lang('Price')">
                                    <strong>{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                </td>

                                <td data-label="@lang('Return /Day')">

                                    @if($data->min_return_per_day == $data->max_return_per_day)
                                    {{ getAmount($data->min_return_per_day) }}
                                    @else

                                    {{ getAmount($data->min_return_per_day) .' - '.getAmount($data->max_return_per_day) }}
                                    @endif
                                    {{ $data->coin_code }}
                                </td>

                                <td data-label="@lang('Total Days')">{{ $data->period }}</td>
                                <td data-label="@lang('Remaining Days')">
                                    {{ $data->period_remain }}
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->status == 0)
                                        <span class="badge badge--warning">@lang('Pending')</span>
                                    @elseif($data->status == 1)
                                        <span class="badge badge--success">@lang('Approved')</span>
                                    @elseif($data->status == 3)
                                        <span class="badge badge--danger">@lang('Expired')</span>
                                    @endif
                                </td>

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
                    {{ $invests->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection


