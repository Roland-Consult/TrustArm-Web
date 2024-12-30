@extends($activeTemplate.'layouts.frontend')

@section('content')


<section class="account py-60">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Sign In Your Account') </h3>
                            <p class="account-form__desc">@lang('Please input your username and password and login to your account to get access to your dashboard.')</p>
                        </div>
                        <form action="{{ route('user.login') }}" method="POST" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="form--label">@lang('Username or Email')</label>

                                        <input type="text" class="form--control" id="email" name="username" value="{{ old('username') }}"  placeholder="Enter username or email">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="your-password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <sapn class="input--icon " rel="#your-password">
                                            <i class="fa-solid fa-eye"></i>
                                            <i class="fa-solid fa-eye-slash show"></i>
                                        </sapn>
                                        <input id="password" type="password" class="form-control form--control" name="password" placeholder="Enter Your Password"
                                        required>

                                    </div>
                                </div>

                                <x-captcha></x-captcha>

                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">

                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">@lang('Remember me') </label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="forgot-password text--base">@lang('Forgot Your Password?')</a>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Sign In')</button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Don\'t Have An Account?') <a href="{{route('user.register')}}" class="have-account__link text--base">@lang('Create Account')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
