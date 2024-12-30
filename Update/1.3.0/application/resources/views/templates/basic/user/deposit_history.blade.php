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
                        <div class="col-lg-12">
                            <div class="order-wrap">
                                <div class="row" style="justify-content: end;">
                                    <div class="col-md-4 mb-3">
                                        <form action="" autocomplete="off">

                                            <div class="header-search-wrap">
                                                <div class="header-search-wrap">
                                                    <div class="search-box-icon-wrapper"><i class="fas fa-search"></i></div>
                                                    <div class="search-box header-search-hide-show">
                                                        <input type="text" name="search" value="{{request()->search}}" class="form--control" placeholder="@lang('Enter Trx...')">
                                                        <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                    <table class="table table--responsive--lg">
                                        <thead>
                                            <tr>
                                                <th>@lang('Payment Gateway')</th>
                                                <th class="text-center">@lang('Amount')</th>
                                                <th class="text-center">@lang('Currency Exchange')</th>
                                                <th>@lang('Trx')</th>
                                                <th class="text-center">@lang('Initiated')</th>
                                                <th class="text-center">@lang('Transaction Status')</th>
                                                <th>@lang('Details')</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse($deposits as $deposit)
                                            <tr>
                                                <td data-label="Transaction">
                                                    <span class="fw-bold"> <span class="text-primary">{{
                                                            __($deposit->gateway?->name) }} </span> </span>

                                                </td>


                                                <td data-label="Amount" class="text-center">
                                                    {{ __($general->cur_sym) }}{{ showAmount($deposit->amount + $deposit->charge) }}

                                                </td>
                                                <td data-label="Conversion" class="text-center">

                                                    <strong>{{ showAmount($deposit->final_amo) }}
                                                        {{__($deposit->method_currency)}}</strong>
                                                </td>

                                                <td data-label="Trx" class="text-center">{{__($deposit->trx)}}</td>

                                                <td data-label="Initiated" class="text-center">
                                                    {{ showDateTime($deposit->created_at) }}
                                                </td>

                                                <td data-label="Status" class="text-center">
                                                    @php echo $deposit->statusBadge @endphp
                                                </td>
                                                @php
                                                $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                                                @endphp

                                                <td data-label="Details">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn--base btn--sm @if($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                                        @if($deposit->method_code >= 1000)
                                                        data-info="{{ $details }}"
                                                        @endif
                                                        @if ($deposit->status == 3)
                                                        data-admin_feedback="{{ $deposit->admin_feedback }}"
                                                        @endif
                                                        >
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                            </tr>
                                            @endforelse
                                        </tbody>


                                    </table>
                               </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData mb-2">

                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--base btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');

            var userData = $(this).data('info');
            var html = '';
            if (userData) {
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                    }
                });
            }

            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);


            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush
