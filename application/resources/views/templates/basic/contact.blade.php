@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
$contact = getContent('contact_us.content',true);
@endphp


<section class="contact-bottom py-80">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5">
                <div class="contact-info">
                    <div class="contact-info__addres-wrap mb-30">
                        <div class="single_wrapper mb-30">
                            <h4 class="mb-30">@lang('Call Us')</h4>
                            <div class="single-info">
                                <div class="cont-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="cont-text m-0">
                                    <a href="javascript:void(0)">{{__($contact->data_values->contact_number)}}</a>

                                </div>
                            </div>
                        </div>
                        <div class="single_wrapper mb-30">
                            <h4>@lang('Email')</h4>
                            <div class="single-info">
                                <div class="cont-icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="cont-text m-0">
                                    <a href="javascript:void(0)">{{__($contact->data_values->email_address)}}</a>

                                </div>
                            </div>
                        </div>
                        <div class="single_wrapper mb-30">
                            <h4>@lang('Address')</h4>
                            <div class="single-info">
                                <div class="cont-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="cont-text m-0">
                                    <a href="javascript:void(0)">{{__($contact->data_values->address)}}</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="contactus-form">
                    <h3 class="contact__title">@lang('Send Us Message') </h3>
                    <form action="" method="POST" autocomplete="off">
                        @csrf
                        <div class="row gy-md-4 gy-3">
                            <div class="col-sm-12">
                                <input type="text" name="name" class="form--control"
                                    value="@if(auth()->user()){{ auth()->user()->fullname }} @else{{ old('name') }}@endif"
                                    @if(auth()->user()) readonly @endif required placeholder="@lang('Your Name*')">
                            </div>
                            <div class="col-sm-12">
                                <input type="email" name="email" class="form--control"
                                    value="@if(auth()->user()){{ auth()->user()->email }}@else{{  old('email') }}@endif"
                                    @if(auth()->user()) readonly @endif required placeholder="@lang('Email Address*')">
                            </div>
                            <div class="col-sm-12">

                                <input name="subject" type="text" class="form--control " value="{{old('subject')}}"
                                    placeholder="@lang('Subject *')" required>
                            </div>

                            <div class="col-sm-12">
                                <textarea class="form--control" name="message" placeholder="@lang('Write Your Message')"
                                    required> {{old('message')}} </textarea>
                            </div>
                            <div class="col-sm-12">
                                <button class=" btn btn--base w-100"> @lang('Send Your Message') <span
                                        class="button__icon ms-1"><i class="fas fa-paper-plane"></i></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div>
    <div class="container-fluid">
        <div class="contact-map">
            <iframe
                src="https://maps.google.com/maps?q={{ $contact->data_values->latitude }},{{ $contact->data_values->longitude }}&hl=es;z=14&amp;output=embed"></iframe>
        </div>
    </div>
</div>


@endsection