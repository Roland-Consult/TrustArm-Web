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
                    <div class="row gy-4 justify-content-center">
                        @if(!auth()->user()->ts)
                        <div class="col-xl-7 col-lg-7">
                            <div class="card custom--card">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                </div>

                                <div class="card-body">
                                    <h6 class="mb-3">@lang('Use the QR code or setup key on your Google Authenticator app to add your account. ')</h6>

                                    <div class="form-group mx-auto text-center">
                                        <img class="mx-auto" src="{{$qrCodeUrl}}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="key">@lang('Setup Key')</label>
                                        <div class="input-group">
                                            <input type="text" name="key" value="{{$secret}}" class="form-control form--control referralURL" readonly>
                                            <button type="button" class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </button>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif



                        <div class="col-xl-5 col-lg-5">
                            @if(auth()->user()->ts)
                            <div class="card custom--card">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Disable 2FA Security')</h5>
                                </div>
                                <form action="{{route('user.twofactor.disable')}}" method="POST">
                                    <div class="card-body">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="form-label required" for="code">@lang('Google Authenticatior OTP')</label>
                                            <input type="text" class="form-control form--control" name="code" required="" id="code">
                                        </div>
                                        <button type="submit" class="btn btn--base h-45 w-100 mt-2">@lang('Submit')</button>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="card custom--card">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Enable 2FA Security')</h5>
                                </div>
                                <form action="{{ route('user.twofactor.enable') }}" method="POST">
                                    <div class="card-body">
                                        @csrf
                                        <input type="hidden" name="key" value="{{$secret}}">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Google Authenticatior OTP')</label>
                                            <input type="text" class="form-control form--control" name="code" required>
                                        </div>
                                        <button type="submit" class="btn btn--base w-100 mt-2">@lang('Submit')</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('style')
<style>
    .copied::after {
        background-color: #{{ $general->base_color }
    }

    ;
    }
</style>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('#copyBoard').on('click', function () {
            var copyText = document.getElementsByClassName("referralURL");
            copyText = copyText[0];
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            copyText.blur();
            this.classList.add('copied');
            setTimeout(() => this.classList.remove('copied'), 1500);
        });
    })(jQuery);
</script>
@endpush
