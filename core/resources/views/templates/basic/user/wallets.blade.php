@extends($activeTemplate.'layouts.user')

@section('content')

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="profile-area">

                    @if($user->coinBalances->count())
                    <form action="" method="post" class="register">
                        @csrf
                        @foreach ($user->coinBalances as $item)
                            <div class="form-group">
                                <label class="d-flex justify-content-between" for="walletAddress{{ $loop->index }}">
                                    {{ $item->coin_code }} @lang('Wallet')
                                    <strong>@lang('Balance'): {{ getAmount($item->balance) }} {{ $item->coin_code }}</strong></label>
                                <input id="walletAddress{{ $loop->index }}" value="{{ $item->wallet }}" type="text" class="form-control" name="address[{{ $item->coin_code }}]" placeholder="Wallet Address">
                            </div>
                        @endforeach

                        <div class="form-group">
                            <input type="submit" class="cmn-btn" value="@lang('Update Wallet')">
                        </div>
                    </form>

                    @else

                    <h5 class="text-danger text-center">@lang('You have no wallet yet, please buy some plan first')</h5>
                    @endif
                </div>
            </div>
        </div>
@endsection
