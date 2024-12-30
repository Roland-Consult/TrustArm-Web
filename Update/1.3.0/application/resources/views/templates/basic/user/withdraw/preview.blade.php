@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row ">
            <div class="col-xl-3 col-lg-4 pe-xl-4">
                @include($activeTemplate.'partials.sidebar')
            </div>

            <div class="col-xl-9 col-lg-12">
                <div class="dashboard-body">
                    <div class="dashboard-body__bar">
                        <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                    </div>
                    <div class="row gy-4">
                        <div class="col-xl-9 col-lg-10">
                            <div class="contactus-form">
                                <h3 class="contact__title"> @lang('Withdraw Via') {{ $withdraw->method->name }}</h3>
                                <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-2">
                                        @php
                                        echo $withdraw->method->description;
                                        @endphp
                                    </div>
                                    <x-custom-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}"></x-custom-form>
                                    @if(auth()->user()->ts)
                                    <div class="form-group ">
                                        <label>@lang('Google Authenticator Code')</label>
                                        <input type="text" name="authenticator_code" class="form-control form--control" required>
                                    </div>
                                    @endif
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
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
