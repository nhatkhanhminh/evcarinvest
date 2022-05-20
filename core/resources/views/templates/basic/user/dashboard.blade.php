@extends($activeTemplate.'layouts.user')
@section('content')
    <!-- dashboard-section start -->
    <div class="row justify-content-center ml-b-60">
        <div class="col-lg-4 col-md-6 col-sm-8 mrb-60">
            <div class="dash-item d-flex flex-wrap">
                <div class="dash-icon">
                    <i class="fab fa-bitcoin fa-4x"></i>
                </div>
                <div class="dash-content">
                    <h3 class="sub-title"><span>@lang($general->cur_text)</span> @lang('Wallet')</h3>
                    <h4 class="title"> <span class="d-block">{{ getAmount(auth()->user()->balance, 8) }}</span></h4>
                </div>
            </div>
        </div>
        @foreach ($miners as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-60">
                <div class="dash-item d-flex flex-wrap">
                    <div class="dash-icon">
                        <i class="fab fa-bitcoin fa-4x"></i>
                    </div>
                    <div class="dash-content">
                        <h3 class="sub-title"><span>{{ $item->coin_code }}</span> @lang('Wallet')</h3>
                        <h4 class="title">{{ getAmount($item->userCoinBalances->balance??0, 8) }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- dashboard-section end -->

    <!-- chart-section start -->
    <section class="chart-section ptb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-header">
                        <h2 class="section-title">@lang('Monthly') <span>@lang('Deposits')</span></h2>
                        <span class="title-border-left"></span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="chart-scroll">
                        <h3 class="title">@lang('Deposit')</h3>
                        <div class="chart-wrapper m-0">
                            <canvas id="depositChart" width="400" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- chart-section start -->
@endsection

@push('script')
    <script>
        'use strict';
        var ctx = document.getElementById('depositChart');
        var depositChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($report['months']->flatten()),
                datasets: [{
                    label: '# Deposits',
                    data: @json($report['deposit_month_amount']->flatten()),
                    backgroundColor: [
                        'rgba(255, 255, 255, 0.1)'
                    ],
                    borderColor: [
                    '#{{ $general->base_color }}'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

        });
    </script>
@endpush
