@extends('admin.layouts.app')

@section('panel')
@if(@json_decode($general->system_info)->message)
<div class="row">
    @foreach(json_decode($general->system_info)->message as $msg)
    <div class="col-md-12">
        <div class="alert border border--primary" role="alert">
            <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
            <p class="alert__message">@php echo $msg; @endphp</p>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="row gy-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Monthly Escrow Report')</h5>
                <div id="escrow-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Daily Logins') (@lang('Last 10 days'))</h5>
                <div id="login-chart"></div>
            </div>
        </div>
    </div>



    <div class="col-xl-6">
        <div class="row gy-4">
            <div class="col-sm-6">
                <a href="{{route('admin.deposit.list')}}">
                    <div class="card prod-p-card background-pattern">
                        <div class="card-body">
                            <div class="row align-items-center m-b-0">
                                <div class="col">
                                    <h6 class="m-b-5">@lang('Total Deposited')</h6>
                                    <h3 class="m-b-0">{{ $general->cur_sym
                                        }}{{showAmount($deposit['total_deposit_amount'])}}</h3>
                                </div>
                                <div class="col-auto">
                                    <i class="dashboard-widget__icon fas fa-hand-holding-usd"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{route('admin.deposit.list')}}">
                    <div class="card prod-p-card background-pattern-white bg--primary">
                        <div class="card-body">
                            <div class="row align-items-center m-b-0">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">@lang('Deposited Charge')</h6>
                                    <h3 class="m-b-0 text-white">{{ $general->cur_sym
                                        }}{{showAmount($deposit['total_deposit_charge'])}}</h3>
                                </div>
                                <div class="col-auto">
                                    <i class="dashboard-widget__icon fas fa-percentage text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{route('admin.withdraw.log')}}">
                    <div class="card prod-p-card background-pattern-white bg--primary">
                        <div class="card-body">
                            <div class="row align-items-center m-b-0">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">@lang('Total Withdrawal')</h6>
                                    <h3 class="m-b-0 text-white">{{ $general->cur_sym
                                        }}{{showAmount($withdrawals['total_withdraw_amount'])}}</h3>
                                </div>
                                <div class="col-auto">
                                    <i class="dashboard-widget__icon lar la-credit-card text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{route('admin.withdraw.approved')}}">
                    <div class="card prod-p-card background-pattern">
                        <div class="card-body">
                            <div class="row align-items-center m-b-0">
                                <div class="col">
                                    <h6 class="m-b-5">@lang('Withdrawal Charge')</h6>
                                    <h3 class="m-b-0">{{ $general->cur_sym
                                        }}{{showAmount($withdrawals['total_withdraw_charge'])}}</h3>
                                </div>
                                <div class="col-auto">
                                    <i class="dashboard-widget__icon fas fa-percentage"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-12">
                <div class="card p-3 rounded-3">
                    <div class="row g-0">
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-users"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.users.all')}}"></a>
                                    <h5>{{$widget['total_users']}}</h5>
                                    <span>@lang('Total Users')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4 ">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-user-check"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.users.active')}}"></a>
                                    <h5>{{$widget['verified_users']}}</h5>
                                    <span>@lang('Active Users')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-envelope"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.users.email.unverified')}}"></a>
                                    <h5>{{$widget['email_unverified_users']}}</h5>
                                    <span>@lang('Email Unverified')</span>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-credit-card"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.withdraw.pending')}}"></a>
                                    <h5>{{$withdrawals['total_withdraw_pending']}}</h5>
                                    <span>@lang('Pending Withdrawals')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-spinner"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.deposit.pending')}}"></a>
                                    <h5>{{$deposit['total_deposit_pending']}}</h5>
                                    <span>@lang('Pending Deposits')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-ban"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.deposit.rejected')}}">
                                    </a>
                                    <h5>{{$deposit['total_deposit_rejected']}}</h5>
                                    <span>@lang('Rejected Deposits')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">@lang('Recent Tickets')</h5>
                    <a href="{{route('admin.ticket.pending')}}" class="float-end" target="_blank">@lang('View all')</a>
                </div>
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newTickets as $item)
                            <tr>
                                <td>
                                    <a class="" href="{{ route('admin.ticket.view', $item->id) }}" class="fw-bold">
                                        @lang('Ticket')#{{ $item->ticket }} - {{ strLimit($item->subject,30) }} </a>
                                </td>
                                <td>
                                    @php echo $item->statusBadge; @endphp
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

<script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>

<script>
    "use strict";


    // [ login-chart ] start
    (function () {
        var options = {
            series: [{
                name: "User Count",
                data: @json($userLogins['values'])
    }],
    chart: {
        height: '310px',
            type: 'area',
                zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    colors: ['#00adad'],
        labels: @json($userLogins['labels']),
    xaxis: {
        type: 'date',
            },
    yaxis: {
        opposite: true
    },
    legend: {
        horizontalAlign: 'left'
    }
        };

    var chart = new ApexCharts(document.querySelector("#login-chart"), options);
    chart.render();
    }) ();


    // escrow report chart..
    (function () {
        var options = {
            series: [{
                name: "Escrow Count",
                data: @json($escrow['values'])
    }],
    chart: {
        height: '310px',
            type: 'area',
                zoom: {
            enabled: true
        }
    },
    dataLabels: {
        enabled: true
    },
    stroke: {
        curve: 'smooth'
    },
    colors: ['#00adad'],
        labels: @json($escrow['labels']),
    xaxis: {
        type: 'date',
            },
    yaxis: {
        opposite: true
    },
    legend: {
        horizontalAlign: 'left'
    }
        };

    var chart = new ApexCharts(document.querySelector("#escrow-chart"), options);
    chart.render();
    }) ();
</script>
@endpush
