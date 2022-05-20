@extends($activeTemplate.'layouts.user')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="profile-area">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                      <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <strong class="">@lang('An withdraw request has been sent to the admin. Please wait for the approval')</strong>
                    </div>
                </div>

                <div class="col-lg-6">
                    <ul class="list-group">
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span class="font-weight-bold">@lang('Requested Amount')</span>
                            <span>{{getAmount($withdraw->amount)  }} {{ $withdraw->userCoinBalance->coin_code }}</span>
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span class="font-weight-bold">@lang('Transaction Id')</span>
                            <span>{{getAmount($withdraw->amount)  }} {{ $withdraw->trx }}</span>
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span class="font-weight-bold">@lang('Remaining Balance')</span>
                            <span>{{ getAmount($withdraw->userCoinBalance->balance) }} {{ $withdraw->userCoinBalance->coin_code }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
