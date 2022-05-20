@extends($activeTemplate.'layouts.user')

@section('content')
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="profile-area">

                    <form action="" method="post" class="register">
                        @csrf
                        <div class="form-group">
                            <label for="password">@lang('Current Password')</label>
                            <input id="password" type="password" class="form-control" name="current_password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('Password')</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">@lang('Confirm Password')</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="cmn-btn" value="@lang('Change Password')">
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

