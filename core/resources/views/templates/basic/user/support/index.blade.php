@extends($activeTemplate.'layouts.user')

@section('content')
<div class="order-section">
    <div class="row">
        <div class="col-lg-12">

            <div class="order-table-area">
                <div class="mb-2 d-flex justify-content-end">
                    <a href="{{route('ticket.open') }}" class="cmn-btn">
                        <i class="fa fa-plus"></i>   @lang('New Ticket')
                    </a>
                </div>

                <table class="order-table">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Subject')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Last Reply')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supports as $key => $support)
                            <tr>
                                <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                <td data-label="@lang('Status')">
                                    @if($support->status == 0)
                                        <span class="badge badge-success ">@lang('Open')</span>
                                    @elseif($support->status == 1)
                                        <span class="badge badge-primary ">@lang('Answered')</span>
                                    @elseif($support->status == 2)
                                        <span class="badge badge-warning ">@lang('Customer Reply')</span>
                                    @elseif($support->status == 3)
                                        <span class="badge badge-dark ">@lang('Closed')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn-primary">
                                        <i class="fa fa-desktop"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$supports->links()}}

        </div>
    </div>
</div>
@endsection

