@extends($activeTemplate.'layouts.master')

@section('content')
@php
$content = getContent('contact_us.content', true);
@endphp
<!-- contact-section start -->
<section class="contact-section register-section pd-t-120">
    <div class="container">

        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-5 mrb-30">
                <div class="contact-thumb">
                    <img src="{{ getImage('assets/images/frontend/contact_us/'.@$content->data_values->image,'618x406') }}" alt="">
                </div>
            </div>
            <div class="col-lg-7 mrb-30">
                <div class="register-form-area">
                    <h3 class="title mb-4">{{ __(@$content->data_values->heading) }}</h3>
                    <span class="title-border"></span>
                    <form method="POST" class="register-form">
                        @csrf
                        <div class="row justify-content-center ml-b-20">
                            <div class="col-lg-6 form-group">
                                <label class="register-icon"><i class="fas fa-pen"></i></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('Your Name')">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="register-icon"><i class="fas fa-envelope"></i></label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="@lang('Your Email')">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="register-icon"><i class="fas fa-book"></i></label>
                                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" placeholder="@lang('Subject')">
                            </div>


                            <div class="col-lg-12 form-group">
                                <textarea name="message" class="form-control" placeholder="@lang('Your Message')">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-lg-12 form-group text-center">
                                <button type="submit" class="submit-btn">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-section end -->

<!-- contact-info start -->
<div class="contact-info-area ptb-120">
    <div class="container">
        <div class="contact-info-item-area">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                    <div class="contact-info-item">
                        <i class="fas fa fa-map-marker-alt"></i>
                        <h3 class="title">@lang('Address')</h3>
                        <p>{{ __(@$content->data_values->contact_details) }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                    <div class="contact-info-item item-one">
                        <i class="fas fa-envelope"></i>
                        <h3 class="title">@lang('Email Address')</h3>
                        <p>{{ @$content->data_values->email_address }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                    <div class="contact-info-item item-two">
                        <i class="fas fa-phone-alt"></i>
                        <h3 class="title">@lang('Phone Number')</h3>
                        <p>{{ @$content->data_values->contact_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact-info end -->

@if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif
@endsection
