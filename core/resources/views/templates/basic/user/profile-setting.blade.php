@extends($activeTemplate.'layouts.user')
@section('content')
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="profile-area">
                    <form class="profile-form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-lg-4 mrb-30">
                                <div class="profile-thumb-upload">
                                    <div class="profile-thumb-preview">
                                        <div class="image-preview bg_img" data-background="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}">
                                        </div>
                                    </div>
                                    <code>@lang('The image will resize into') {{imagePath()['profile']['user']['size']}}</code>
                                    <div class="profile-edit">
                                        <input type="file" name="image" id="imageUpload" class="upload" accept=".png, .jpg, .jpeg">
                                        <label for="imageUpload" class="imgUp mrt-20">
                                            @lang('Upload Image')
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 mrb-30">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="InputFirstname">@lang('First Name'):</label>
                                        <input type="text" class="form-control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" >
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="lastname">@lang('Last Name'):</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}">
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Username')</label>
                                        <input type="text" placeholder="Username" class="form-control" value="{{$user->username}}" readonly>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="email">@lang('E-mail Address'):</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="hidden" id="track" name="country_code">
                                        <label for="phone">@lang('Mobile Number')</label>
                                        <input type="tel" class="form-control" id="phone" name="mobile" value="{{$user->mobile}}" placeholder="@lang('Your Contact Number')" readonly>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="country">@lang('Country'):</label>
                                        <input type="text" id="country" class="form-control" value="{{@$user->address->country}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-footer">
                            <div class="row justify-content-center ml-b-20">
                                <div class="form-group col-lg-6">
                                    <label for="address">@lang('Address'):</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="state">@lang('State'):</label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="zip">@lang('Zip Code'):</label>
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="city">@lang('City'):</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="submit-btn">@lang('Update Profile')</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
@endsection

@push('script')
<script>
    'use strict';
    (function($){

        $('.imgUp').on('click', function () {
            upload();
        });
        function upload() {
            $(".upload").on('change',function () {
                readURL(this);
            });
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader(); reader.onload = function (e) {
                    var preview = $(input).parents('.profile-thumb-upload').find('.image-preview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    })(jQuery)
</script>

@endpush

