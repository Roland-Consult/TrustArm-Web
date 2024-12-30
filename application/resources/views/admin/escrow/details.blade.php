@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>{{ __($escrow->title) }} </h6>
                        <a href="{{ route('admin.escrow.milestone', $escrow->id) }}"
                            class="btn btn-outline-primary text-end">@lang('Milestones')</a>

                    </div>
                </div>
                <div class="card-body">

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Buyer')</span>
                            <span>
                                @if ($escrow->buyer_id != 0)
                                    {{ __(@$escrow->buyer->firstname) }}_{{ __(@$escrow->buyer->lastname) }}
                                @else
                                    {{ __(@$escrow->mail_invitation) }}
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Seller')</span>
                            <span>
                                @if ($escrow->seller_id != 0)
                                    {{ __(@$escrow->seller->firstname) }} {{ __(@$escrow->seller->lastname) }}
                                @else
                                    {{ __(@$escrow->mail_invitation) }}
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Amount')</span>
                            <span>{{ showAmount($escrow->amount) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Charge')</span>
                            <span>{{ showAmount($escrow->charge) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Payer of Charges')</span>
                            <span>
                                <span class="badge badge--primary">
                                    @if ($escrow->charge_sender == 1)
                                        @lang('Seller')
                                    @elseif($escrow->charge_sender == 2)
                                        @lang('Buyer')
                                    @else
                                        @lang('Seller(50%) - Buyer(50%)')
                                    @endif
                                </span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Status')</span>
                            <span>
                                <span class="badge badge--primary">
                                    @if ($escrow->status == 0)
                                        @lang('Not accepted')
                                    @elseif($escrow->status == 1)
                                        @lang('Dispatched')
                                    @elseif($escrow->status == 2)
                                        @lang('Accepted')
                                    @elseif($escrow->status == 3)
                                        @lang('Disputed')
                                    @elseif($escrow->status == 4)
                                        @lang('Canceled')
                                    @endif
                                </span>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Established Milestone')</span>
                            <span>{{ showAmount($created) }} {{ $general->cur_text }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Paid Milestone')</span>
                            <span>{{ showAmount($funded) }} {{ $general->cur_text }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Unpaid Milestone')</span>
                            <span>{{ showAmount($unfunded) }} {{ $general->cur_text }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Remaining Amount')</span>
                            <span>{{ showAmount($rest_amount) }} {{ $general->cur_text }}</span>
                        </li>

                        @if ($escrow->status == 3)
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-bold">@lang('Disputed By') & @lang(' Reason')</span>
                                <span> {{ __($escrow->disputer->username) }} | {{ __($escrow->dispute_reason) }}</span>
                            </li>
                        @endif

                    </ul>
                </div>

            </div>
        </div>

    </div>


    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Action of Diputed Escrow')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.escrow.dispute.action') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="">
                            <label class="fw-bold"> @lang('Funded Amount')</label>
                            <input type="text" class="form-control name" name="funded_amount"
                                value="{{ showAmount($funded) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold"> @lang('Amount return to seller')</label>
                            <input type="text" class="form-control name" name="seller_amount" required>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold"> @lang('Amount return to Buyer')</label>
                            <input type="text" class="form-control name" name="buyer_amount" required>
                        </div>

                        <div class="form-group">
                            <label for="fw-bold">@lang('Status')</label>
                            <select name="status" class="form-control">
                                <option value="1">@lang('Dispatched / Completed')</option>
                                <option value="4">@lang('Canceled')</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if ($escrow->status == 3)
        <button type="button" class="btn btn-sm btn--primary addBtn" data-id="{{ $escrow->id }}"><i
                class="las la-plus"></i>@lang('Take Action')</button>
    @endif
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addBtn').on('click', function() {
                var modal = $('#addModal');
                modal.find('input[name=id]').val($(this).data('id'))

                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
