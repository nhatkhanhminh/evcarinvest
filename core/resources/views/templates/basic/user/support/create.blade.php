@extends($activeTemplate.'layouts.user')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white d-flex flex-wrap align-items-center justify-content-between">{{ __($page_title) }}
                        <a href="{{route('ticket') }}" class="cmn-btn">
                            @lang('My Support Ticket')
                        </a>
                    </div>

                    <div class="card-body">
                        <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">@lang('Name')</label>
                                    <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control form-control-lg" placeholder="@lang('Enter Name')" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">@lang('Email address')</label>
                                    <input type="email"  name="email" value="{{@$user->email}}" class="form-control form-control-lg" placeholder="@lang('Enter your Email')" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="website">@lang('Subject')</label>
                                    <input type="text" name="subject" value="{{old('subject')}}" class="form-control form-control-lg" placeholder="@lang('Subject')" >
                                </div>
                                <div class="col-12 form-group">
                                    <label for="inputMessage">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="6" class="form-control form-control-lg">{{old('message')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <span for="inputAttachments text-white">@lang('Attachments')</span>
                                <div class="custom-file">
                                    <input name="attachments[]" type="file" id="customFile" class="custom-file-input" accept=".jpg,.jpeg,.png,.pdf">

                                    <label class="custom-file-label form-control-lg" for="custmFile">@lang('Choose file')</label>
                                </div>
                            </div>

                            <div class="fileUploadsContainer"></div>

                            <p class="text-muted m-2">
                                <i class="la la-info-circle"></i> @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf")
                            </p>

                            <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-success rounded add-more-btn">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-12 justify-content-center">
                                    <button class="submit-btn" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
       'use strict';
        (function($){
            $(document).on("change", '.custom-file-input' ,function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            var itr = 0;

            $('.add-more-btn').on('click', function(){
                itr++
                $(".fileUploadsContainer").append(` <div class="form-group custom-file mt-3">
                                            <input type="file" name="attachments[]" id="customFile${itr}" class="custom-file-input" accept=".jpg,.jpeg,.png,.pdf" />
                                            <label class="custom-file-label form-control-lg" for="customFile${itr}">@lang('Choose file')</label>
                                        </div>`);

            });

        })(jQuery)
    </script>
@endpush


@push('breadcrumb-plugins')
<li class="breadcrumb-item"><a href="{{route('ticket') }}">@lang('Support Tickets')</a></li>
@endpush
