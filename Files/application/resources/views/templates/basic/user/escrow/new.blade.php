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
                                    <h3 class="contact__title"> @lang('Create New Escrow')</h3>
                                    <form action="{{route('user.escrow.info')}}" method="post" autocomplete="off">
                                        @csrf
                                        <div class="row gy-md-4 gy-3">
                                        <div class="col-sm-12">
                                            <select class="select form--control" name="type">
                                                <option value="">@lang('Select One ')</option>
                                                <option selected="" value="1">@lang('I Am Selling')</option>
                                                <option value="2">@lang('I Am Buying')</option>
                                            </select>
                                            </div>
                                        <div class="col-sm-12">
                                                <select class="select form--control" name="category_id">
                                                    @foreach ($categories as $item)
                                                    <option value="{{$item->id}}">{{__($item->name)}}</option>
                                                    @endforeach

                                                </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input-group escro-doller">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{__($general->cur_sym)}}</span>
                                                </div>
                                                <input type="text" name="amount" class="form--control" placeholder="@lang('For the Amount Of') {{__($general->cur_text)}}">
                                            </div>
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

