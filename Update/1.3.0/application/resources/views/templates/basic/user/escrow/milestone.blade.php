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
                    <!-- Button trigger modal -->
                    @if ($escrow->buyer_id == auth()->user()->id && $escrow->status != 3)
                        <button type="button" class="btn btn--base btn--sm mb-2 add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            @lang('Create Milestone')
                        </button>

                    @endif

                    <div class="row gy-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="order-wrap">
                                <table class="table table--responsive--lg text-center">
                                    <thead>
                                        <tr>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Payment Type')</th>
                                            <th>@lang('Short Note')</th>
                                            <th>@lang('Date')</th>

                                            @if ($escrow->buyer_id == auth()->user()->id)
                                            <th>@lang('Action')</th>
                                            @endif

                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($milestones as $item)
                                        <tr>

                                            <td >{{ __($general->cur_sym) }} {{showAmount($item->amount)}} </td>
                                            <td>
                                                @if ($item->payment_type ==1)
                                                    <span class="badge badge--success">@lang('Paid')</span>
                                                @else
                                                    <span class="badge badge--danger">@lang('Unpaid')</span>
                                                @endif
                                            </td>
                                            <td>{{__($item->details)}}</td>
                                            <td>{{($item->created_at)->format('Y-m-d')}}</td>
                                            @if ($escrow->buyer_id == auth()->user()->id)
                                            <td>

                                                @if ($item->payment_type == 1)
                                                  <button type="button" class="btn btn--base btn--sm" disabled data-bs-toggle="button" autocomplete="off">@lang('Pay')</button>
                                                @else
                                                    <button type="button" class="btn btn--base btn--sm paynow" data-bs-toggle="modal" data-bs-target="#paynow" data-user_id="{{$item->user_id}}" data-id="{{__($item->id)}}" data-amount="{{showAmount($item->amount)}}" data-seller="{{__($item->escrow->seller_id)}}" >
                                                    @lang('Pay')
                                                    </button>
                                                @endif
                                            </td>
                                            @endif

                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
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
<!-- create milestone Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Create Milestone')</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="" method="post">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="escrow_id" value="{{$escrow->id}}">

                <div class="form-group">
                    <label for="">@lang('Rest Amount')</label>
                    <input type="text" class="form--control" id="" value="{{ showAmount($rest_amount)}} {{__($general->cur_text) }}"  readonly>
                </div>
                <div class="form-group">
                    <label for="">@lang('Amount')</label>
                    <input type="number" step="any" class="form--control" name="amount" id="" placeholder="@lang('Enter amount')">
                </div>
                <div class="form-group">
                    <label for="" required>@lang('Short Note')</label>
                    <input type="text" class="form--control" name="note" id="" placeholder="@lang('Enter note')">
                </div>

            </div>
            <div class="modal-footer">

              <button type="submit" class="btn btn--base btn--sm">@lang('Save Milestone')</button>
            </div>
        </form>

      </div>
    </div>
</div>

{{-- payment modal --}}
  <!-- Modal -->
  <div class="modal fade" id="paynow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content ">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-warning" id="exampleModalLabel">@lang('Pay Milestone')</h1>
          <button type="button" class="btn-close btn btn--base btn--sm " data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <form action="{{route('user.paynow')}}" method="post">
            @csrf
            <div class="modal-body ">
                <input type="hidden" name="id" id="">
                <input type="hidden" name="user_id" id="">
                <input type="hidden" name="amount" id="">
                <input type="hidden" name="seller_id" id="">
                <input type="hidden" name="buyer_charge">

                <label for="type">@lang('Payment System')</label>
                <select class="select form--control" name="payment" required>
                    <option value="1">@lang('Wallet - ')
                        @php
                            $balance = auth()->user()->balance;
                        @endphp
                        {{showAmount($balance)}}
                    </option>
                    <option value="2">@lang('Direct Payment')</option>
                </select>
            </div>
            <div class="modal-footer">

              <button type="submit" class="btn btn--base btn--sm">@lang('Pay')</button>
            </div>
        </form>
      </div>
    </div>
  </div>


@endsection

@push('script')

  <script>
    (function($){
        "use strict";
        $('.add').on('click',function(){
            var modal = $('#exampleModal');
            modal.find('show');
        })
    })(jQuery);
  </script>

  <script>
    (function($){
        "use strict";
        $('.paynow').on('click',function(){
            var modal = $('#paynow');

            modal.find('input[name=id]').val($(this).data('id'))
            modal.find('input[name=user_id]').val($(this).data('user_id'))
            modal.find('input[name=amount]').val($(this).data('amount'))
            modal.find('input[name=seller_id]').val($(this).data('seller'))
            modal.find('input[name=buyer_charge]').val($(this).data('buyer_charge'))
            modal.modal('show');
        })
    })(jQuery);
  </script>
@endpush


