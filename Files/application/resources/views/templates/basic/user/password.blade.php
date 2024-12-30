@extends($activeTemplate.'layouts.master')

@section('content')

<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 pe-xl-4">
                @include($activeTemplate.'partials.sidebar')
            </div>
            <div class="col-xl-9 col-lg-12">
                <div class="dashboard-body">
                    <div class="dashboard-body__bar">
                        <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                    </div>
                    <div class="row gy-4">
                        <div class="col-xl-10 col-lg-10">
                            <div class="user-profile">
                                <form action="" method="post">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-sm-12">
                                            <h4>@lang('Change Password')</h4>
                                        </div>
                                        <div class="col-sm-12">

                                            <label class="form-label">@lang('Current Password')</label>
                                            <div class="input-group">
                                                <sapn class="input--icon " rel="#your-password">
                                                    <i class="fa-solid fa-eye"></i>
                                                    <i class="fa-solid fa-eye-slash show"></i>
                                                </sapn>
                                                <input id="your-password" type="password" class="form-control form--control" value="Password" name="current_password" required
                                                autocomplete="current-password">
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <label for="new-password" class="form--label required">@lang('New Password') </label>
                                            <div class="input-group">
                                                <sapn class="input--icon " rel="#new-password">
                                                    <i class="fa-solid fa-eye"></i>
                                                    <i class="fa-solid fa-eye-slash show"></i>
                                                </sapn>

                                                <input type="password" class="form-control form--control" name="password" required
                                                autocomplete="current-password">
                                                @if($general->secure_password)
                                                <div class="input-popup">
                                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                                    <p class="error number">@lang('1 number minimum')</p>
                                                    <p class="error special">@lang('1 special character minimum')</p>
                                                    <p class="error minimum">@lang('6 character password')</p>
                                                </div>
                                                @endif



                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="again-your-password" class="form--label required">@lang('Confirm Password') </label>
                                            <div class="input-group">
                                                <sapn class="input--icon " rel="#again-your-password">
                                                    <i class="fa-solid fa-eye"></i>
                                                    <i class="fa-solid fa-eye-slash show"></i>
                                                </sapn>

                                                <input id="again-your-password" type="password" class="form-control form--control" name="password_confirmation"
                                                required value="Password">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn--base w-100">@lang('Save Now')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });

        @endif
    })(jQuery);
</script>
@endpush
