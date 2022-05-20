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
                                <th scope="col">@lang('Coin')</th>
                                <th scope="col">@lang('Wallet')</th>
                                <th scope="col">@lang('Balance')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($coins as $data)
                            <tr>
                                <td data-label="@lang('S.N.')">{{$data->current_page-1 * $data->per_page + $loop->iteration }}</td>

                                <td data-label="@lang('Coin')">
                                    {{ $data->coin_code }}
                                </td>

                                <td data-label="@lang('Wallet')">@lang($data->wallet??'NA')</td>
                                <td data-label="@lang('Balance')">{{ getAmount($data->balance, 8) }}</td>



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
                    {{ $coins->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection


