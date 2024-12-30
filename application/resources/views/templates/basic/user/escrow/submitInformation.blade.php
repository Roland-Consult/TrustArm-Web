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
                        <div class="col-xl-9 col-lg-10">
                            <div class="banner-form-wrap">
                                <div class="contactus-form">
                                    <h3 class="contact__title"> {{$pageTitle}}</h3>
                                    <form action="" method="post" autocomplete="off">
                                        @csrf
                                        <div class="row gy-md-4 gy-3">

                                            <input type="hidden" name="type" value="{{$type}}">
                                            <input type="hidden" name="category_id" value="{{$category_id}}">

                                            <div class="col-sm-6">
                                                <label for="title" required>@lang('Title')</label>
                                                <input type="text" class="form--control" name="title" id="title" placeholder="@lang('Enter title')">
                                            </div>
                                            <div class="col-sm-6">
                                                @if($type==1)
                                                <label for="email">@lang('Buyer\'s Email')</label>
                                                @else
                                                <label for="email">@lang('Seller\'s Email')</label>
                                                @endif
                                                <input type="email" class="form--control" name="email" id="email" placeholder="@lang('Enter email')">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="amount" required>@lang('Amount')</label>
                                                <input type="text" class="form--control" name="amount" value="{{$amount}}" id="amount" placeholder="@lang('Enter amount')" readonly>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="charge">@lang('Charge')</label>
                                                <input type="text" class="form--control" name="charge" value="{{$session_charge}}" id="charge" placeholder="@lang('Enter charge')" readonly>
                                            </div>



                                            <div class="col-sm-12">
                                                <label for="charge_pay" required>@lang('Will Charge Pay')</label>
                                                <select class="select form--control" name="charge_sender">
                                                    <option value=" ">@lang('Select One ')</option>
                                                    <option value="1">@lang('Seller')</option>
                                                    <option value="2">@lang('Buyer')</option>
                                                    <option value="3">@lang('Seller (50%) - Buyer (50%)')</option>
                                                </select>

                                            </div>


                                        <div class="col-sm-12">
                                            <label for="details">@lang('Details')</label>
                                            <textarea name="details" class="form--control" id="" cols="30" rows="10" placeholder="@lang('Write details ...')"></textarea>
                                        </div>
                                            <div class="col-sm-12">
                                                <button class=" btn btn--base"> @lang('Continue')</button>
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
</div>

@endsection

