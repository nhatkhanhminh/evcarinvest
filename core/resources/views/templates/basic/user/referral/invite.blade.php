@extends($activeTemplate.'layouts.user')

@section('content')

        <div class="row">
            <div class="col-lg-12">

                <h3>@lang('Your Referral Link')</h3>
                <div class="form-group">
                    <div class="input-group">
                        <input type="url" id="ref" value="{{ route('home').'?ref='.auth()->user()->username }}" class="form-control form-control-lg bg-transparent" readonly>
                        <div class="input-group-append">
                            <button  type="button"  data-copytarget="#ref" class="input-group-text bg--info border--light text--white copybtn"><i class="fa fa-copy"></i> &nbsp; @lang('Copy')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-section pd-t-30 pd-b-80">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-12 mrb-30">

                    <h3>@lang('Your Referees')</h3>
                    <div class="order-table-area">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('User')</th>
                                    <th scope="col">@lang('Plan Purchased')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($referees) >0)
                                    @foreach($referees as $k=>$data)
                                        <tr>
                                            <td data-label="@lang('User')">{{$data->username}}</td>
                                            <td data-label="@lang('Plan Purchased')">
                                                <strong>
                                                    {{getAmount($data->paidOrders->sum('amount'))}} {{__($general->cur_text)}}
                                                </strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%"> @lang('No refree yet')!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{$referees->links()}}
                    </div>
                </div>
            </div>
        </div>
@endsection


@push('script')

    <script>
        'use strict';
        document.querySelectorAll('.copybtn').forEach((element)=>{
            element.addEventListener('click', copy, true);
        })

        function copy(e) {
            var
                t = e.target,
                c = t.dataset.copytarget,
                inp = (c ? document.querySelector(c) : null);
            if (inp && inp.select) {
                inp.select();
                try {
                    document.execCommand('copy');
                    inp.blur();
                    t.classList.add('copied');
                    setTimeout(function() { t.classList.remove('copied'); }, 1500);
                }catch (err) {
                    alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
                }
            }
        }
    </script>
@endpush


@push('style')
    <style>
        .copyInput {
            display: inline-block;
            line-height: 50px;
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            text-align: center;
            font-size: 14px;
            cursor: pointer;
            -webkit-transition: all .3s;
            -o-transition: all .3s;
            transition: all .3s;
        }

        .copied::after {
            position: absolute;
            top: 10px;
            right: 12%;
            width: 100px;
            display: block;
            content: "COPIED";
            font-size: 1em;
            padding: 2px 5px;
            color: #fff;
            border-radius: 3px;
            opacity: 0;
            will-change: opacity, transform;
            animation: showcopied 1.5s ease;
            background-color: #{{ $general->base_color }};
        }


        @keyframes showcopied {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }
            50% {
                opacity: 0.7;
                transform: translateX(40%);
            }
            70% {
                opacity: 1;
                transform: translateX(0);
            }
            100% {
                opacity: 0;
            }
        }

    </style>
@endpush
