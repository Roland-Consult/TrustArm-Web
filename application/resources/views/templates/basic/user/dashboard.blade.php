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
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-info">
                                    <div class="dashboard-card__icon">
                                        <i class="las la-hand-holding-usd"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Balance')</h5>
                                        <h4 class="dashboard-card__amount">{{showAmount($user['balance'])}} {{$general->cur_text}} </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-violet">
                                    <div class="dashboard-card__link mt-4">
                                        <a href="{{route('user.deposit.pending.all')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="las la-info-circle"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Pending Deposits')</h5>
                                        <h4 class="dashboard-card__amount">{{__($user['deposit_pending'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-success">
                                    <div class="dashboard-card__link mt-4">
                                        <a href="{{route('user.withdraw.pending.all')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="las la-file-invoice-dollar"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Pending Withdrawals')</h5>
                                        <h4 class="dashboard-card__amount">{{__($user['withdraw_pending'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-violet-1">
                                    <div class="dashboard-card__link mt-4">
                                        <a href="{{route('user.escrow.list')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="la la-handshake"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Total Escrow')</h5>
                                        <h4 class="dashboard-card__amount">{{__($escrow['total'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-warning">
                                    <div class="dashboard-card__link mt-4">
                                        <a href="{{route('user.escrow.list','not_accepted')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="las la-radiation-alt"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Not Accepted')</h5>
                                        <h4 class="dashboard-card__amount">{{__($escrow['not_accepted'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-info">
                                    <div class="dashboard-card__link mt-4">
                                        <a href="{{route('user.escrow.list','accepted')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="las la-redo-alt"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Running Escrow')</h5>
                                        <h4 class="dashboard-card__amount">{{__($escrow['running'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-success-1">
                                    <div class="dashboard-card__link">
                                        <a href="{{route('user.escrow.list','dispatched')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="lar la-check-circle"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Completed')</h5>
                                        <h4 class="dashboard-card__amount">{{__($escrow['dispatched'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-info">
                                    <div class="dashboard-card__link">
                                        <a href="{{route('user.escrow.list','disputed')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="las la-bomb"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Disputed')</h5>
                                        <h4 class="dashboard-card__amount">{{__($escrow['disputed'])}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6">
                                <div class="dashboard-card card-danger">
                                    <div class="dashboard-card__link">
                                        <a href="{{route('user.escrow.list','canceled')}}">
                                            <i class="las la-link"></i> @lang('View All')
                                        </a>
                                    </div>
                                    <div class="dashboard-card__icon">
                                        <i class="las la-times"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Canceled')</h5>
                                        <h4 class="dashboard-card__amount">{{__($escrow['canceled'])}}</h4>
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
