@extends('admin.layouts.app')

@section('panel')
@if(@json_decode($general->sys_version)->version > systemDetails()['version'])
<div class="row">
    <div class="col-md-12">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">
                <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-right">@lang('Version') {{json_decode($general->sys_version)->version}}</button> </h3>
            </div>
            <div class="card-body">
                <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                <p><pre  class="f-size--24">{{json_decode($general->sys_version)->details}}</pre></p>
            </div>
        </div>
    </div>
</div>
@endif
@if(@json_decode($general->sys_version)->message)
<div class="row">
    @foreach(json_decode($general->sys_version)->message as $msg)
    <div class="col-md-12">
        <div class="alert border border--primary" role="alert">
          <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
          <p class="alert__message">@php echo $msg; @endphp</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>
@endforeach
</div>
@endif

    <div class="row mb-none-30">
        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_users']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Users')</span>
                    </div>
                    <a href="{{route('admin.users.all')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['verified_users']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Verified Users')</span>
                    </div>
                    <a href="{{route('admin.users.active')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--orange b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="la la-envelope"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['email_unverified_users']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Email Unverified Users')</span>
                    </div>

                    <a href="{{route('admin.users.emailUnverified')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--pink b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['sms_unverified_users']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total SMS Unverified Users')</span>
                    </div>

                    <a href="{{route('admin.users.smsUnverified')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->


        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-44 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-hammer"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_miner'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Miner')</span>
                    </div>

                    <a href="{{ route('admin.miner.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-7 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_plan'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Plan')</span>
                    </div>

                    <a href="#0" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-50 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_sale_count'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Sale')</span>
                    </div>

                    <a href="{{ route('admin.sale.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-35 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-bar-chart"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($widget['total_sale_amount']) }}</span>
                        <span class="currency-sign">{{ $general->cur_text }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Sale Amount')</span>
                    </div>

                    <a href="{{ route('admin.sale.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mt-50 mb-none-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly  Deposit & Withdraw  Report')</h5>
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="row mb-none-30">
                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--primary box--shadow2">
                            <i class="las la-wallet "></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{$payment['total_deposit']}}</h2>
                            <p  class="text--small">@lang('Total Deposit')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--pink  box--shadow2">
                            <i class="las la-money-bill "></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{getAmount($payment['total_deposit_amount'])}} {{__($general->cur_text)}}</h2>
                            <p class="text--small">@lang('Total Deposit')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--teal box--shadow2">
                            <i class="las la-money-check"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{getAmount($payment['total_deposit_charge'])}} {{__($general->cur_text)}}</h2>
                            <p class="text--small">@lang('Total Deposit Charge')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--green  box--shadow2">
                            <i class="las la-money-bill-wave "></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{$payment['total_deposit_pending']}}</h2>
                            <p class="text--small">@lang('Pending Deposit')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
            </div>
        </div>
    </div><!-- row end -->

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-6 mb-30">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title mb-0">@lang('Latest Deposits')</h6>
                    <h6 class="card-title mb-0">
                        <a class="btn btn--primary" href="{{ route('admin.deposit.list') }}">@lang('View All')</a>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Trx Number')</th>
                                <th scope="col">@lang('Method')</th>
                                <th scope="col">@lang('Amount')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($latestDeposits as $deposit)
                                <tr>

                                    <td data-label="@lang('User')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$deposit->user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')"></div>
                                            <span class="name"><a href="{{ route('admin.users.detail', $deposit->user->id) }}">{{ $deposit->user->username }}</a></span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Trx Number')" class="font-weight-bold text-uppercase">{{ $deposit->trx }}</td>
                                    <td data-label="@lang('Method')">{{ __($deposit->gateway->name) }}</td>
                                    <td data-label="@lang('Amount')">{{ getAmount($deposit->amount ) }} {{ __($general->cur_text) }}</td>

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
            </div><!-- card end -->
        </div>

        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title mb-0">@lang('Latest Withdraws')</h6>
                    <h6 class="card-title mb-0">
                        <a class="btn btn--primary" href="{{ route('admin.withdraw.log') }}">@lang('View All')</a>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Trx Number')</th>
                                <th scope="col">@lang('Wallet')</th>
                                <th scope="col">@lang('Amount')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($latestWithdraws as $withdraw)
                                <tr>

                                    <td data-label="@lang('User')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$withdraw->user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')"></div>
                                            <span class="name"><a href="{{ route('admin.users.detail', $withdraw->user->id) }}">{{ $withdraw->user->username }}</a></span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Trx Number')" class="font-weight-bold text-uppercase">{{ $withdraw->trx }}</td>
                                    <td data-label="@lang('Wallet')">{{ __($withdraw->userCoinBalance->wallet) }}</td>
                                    <td data-label="@lang('Amount')">{{ getAmount($withdraw->amount ) }} {{ __($withdraw->userCoinBalance->coin_code) }}</td>
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
            </div>
        </div>


    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-lg-4 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser')</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS')</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country')</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.cron_instruction')

@endsection


@push('breadcrumb-plugins')

    @if($general->last_cron)
    <a href="javascript:void(0)" class="btn @if(Carbon\Carbon::parse($general->last_cron)->diffInSeconds()<600)
        btn--success @elseif(Carbon\Carbon::parse($general->last_cron)->diffInSeconds()<1200) btn--warning @else
        btn--danger @endif "><i class="fa fa-fw fa-clock"></i>@lang('Last Cron Run') : {{Carbon\Carbon::parse($general->last_cron)->difFforHumans()}}</a>

    @endif

@endpush

@push('script')

    <script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>

    <script>
        "use strict";
          // apex-bar-chart js
          var options = {
              series: [{
                  name: 'Total Deposit',
                  data: [
                    @foreach($report['months'] as $month)
                      {{ getAmount(@$depositsMonth->where('months',$month)->first()->depositAmount) }},
                    @endforeach
                  ]
              }],
              chart: {
                  type: 'bar',
                  height: 400,
                  toolbar: {
                      show: false
                  }
              },
              plotOptions: {
                  bar: {
                      horizontal: false,
                      columnWidth: '50%',
                      endingShape: 'rounded'
                  },
              },
              dataLabels: {
                  enabled: true
              },
              stroke: {
                  show: true,
                  width: 2,
                  colors: ['transparent']
              },
              xaxis: {
                  categories: @json($report['months']->flatten()),
              },
              yaxis: {
                  title: {
                      text: "{{__($general->cur_sym)}}",
                      style: {
                          color: '#7c97bb'
                      }
                  }
              },
              grid: {
                  xaxis: {
                      lines: {
                          show: false
                      }
                  },
                  yaxis: {
                      lines: {
                          show: false
                      }
                  },
              },
              fill: {
                  opacity: 1
              },
              tooltip: {
                  y: {
                      formatter: function (val) {
                          return "{{__($general->cur_sym)}}" + val + " "
                      }
                  }
              }
          };
          var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
          chart.render();


        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });



        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
@endpush
