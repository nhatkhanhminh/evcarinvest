@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Time')</th>
                                    <th scope="col">@lang('Received By')</th>
                                    <th scope="col">@lang('Referee')</th>
                                    <th scope="col">@lang('Amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <tr>
                                        <td data-label="@lang('Time')">
                                            {{showDateTime($log->created_at)}}
                                        </td>
                                        <td data-label="#@lang('Received By')">{{$log->user->username}}</td>
                                        <td data-label="#@lang('Referee')">{{$log->referee->username}}</td>

                                        <td data-label="@lang('Amount')">
                                            <strong>
                                                {{getAmount($log->amount)}} {{__($general->cur_text)}}
                                            </strong>
                                        </td>

                                    </tr>
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
                @if($logs->hasPages())
                <div class="card-footer py-4">
                    {{ $logs->links('admin.partials.paginate') }}
                </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection


