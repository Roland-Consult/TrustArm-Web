@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard py-80 section-bg-two">
    <div class="container">
        <div class="row justify-content-center gy-4">
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header selling-header">
                        <h5 class="card-title">{{__($escrow->category->name)}}</h5>
                        <a href="{{route('user.escrow.milestone',$escrow->id)}}" class="btn btn--base btn--sm">@lang('Look at Milestones') <i class="las la-angle-right"></i></a>
                    </div>

                    <div class="card-body">

                        <div class="selling-group-item">

                            <small class="text-muted">@lang('Title')</small>
                            <span>{{__($escrow->title)}}</span>
                        </div>

                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Escrow Number')</small>
                            <span>{{__($escrow->escrow_number)}}</span>
                        </div>

                        <div class="selling-group-item">

                            @if (($escrow->seller_id == auth()->user()->id) || ($escrow->seller_id == 0))
                            <small class="fw-bold">@lang('Buyer\'s')</small>
                            @elseif(($escrow->buyer_id == auth()->user()->id) || ($escrow->buyer_id == 0))
                            <small class="fw-bold">@lang('Seller\'s')</small>
                            @endif

                            <span>
                                @if($escrow->seller_id == auth()->user()->id)
                                    {{__($escrow->buyer->username ?? $escrow->mail_invitation)}}
                                @else
                                    {{__($escrow->seller->username ?? $escrow->mail_invitation)}}

                                @endif

                            </span>

                        </div>

                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Escrow Status')</small>

                                @if ($escrow->status == 0)
                                    <span class="badge badge--warning">@lang('Not accepted') </span>
                                    @elseif($escrow->status == 1)
                                    <span class="badge badge--primary">@lang('Dispatched') </span>
                                    @elseif($escrow->status == 2)
                                    <span class="badge badge--success">@lang('Accepted')</span>
                                    @elseif($escrow->status == 3)
                                    <span class="badge badge--primary">@lang('Disputed') </span>
                                    @else
                                    <span class="badge badge--danger">@lang('Cancel') </span>
                                 @endif

                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Amount')</small>
                            <span> {{showAmount($escrow->amount)}} {{__($general->cur_text)}}</span>
                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Charge')</small>
                            <span> {{showAmount($escrow->charge)}} {{__($general->cur_text)}}</span>
                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Payer of Charges')</small>
                            <span class="badge badge--success">
                                @if ($escrow->charge_sender == 1)
                                    @lang('Seller')
                                @elseif($escrow->charge_sender == 2)
                                    @lang('Buyer')
                                @else @lang('Buyer(50%) - Seller(50%)')
                                @endif
                            </span>
                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Established  Milestone')</small>
                            <span> {{showAmount($created)}} {{__($general->cur_text)}}</span>
                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Paid Milestone ')</small>
                            <span> {{showAmount($funded)}} {{__($general->cur_text)}} </span>
                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Unpaid Milestone ')</small>
                            <span> {{showAmount($unfunded)}} {{__($general->cur_text)}} </span>
                        </div>
                        <div class="selling-group-item">
                            <small class="text-muted">@lang('Remaining Amount')</small>
                            <span> {{showAmount($rest_amount)}} {{__($general->cur_text)}} </span>
                        </div>


                        @if ($escrow->status == 3)
                            <div class="selling-group-item">
                                <small class="text-muted">@lang('Disputed By')</small>
                                <span> {{__($escrow->disputer->username)}} </span>
                            </div>

                            <div class="selling-group-item">
                                <small class="text-muted">@lang('Dispute Reason')</small>
                                <span> {{__($escrow->dispute_reason)}} </span>
                            </div>
                        @endif




                    @if ($escrow->status == 2)

                        @if (($escrow->status != 3))
                            <button type="button" class="btn btn-danger btn-sm dispute mt-2 p-2" data-bs-toggle="modal" data-bs-target="#dispute" data-id="{{$escrow->id}}">@lang('Dispute Escrow')</button>
                        @endif

                    @endif

                    @if(($rest_amount <= 0 )  && ($escrow->status == 0))
                        <div class="alert alert-warning mt-2" role="alert"> @lang('Even though the entire sum has been paid, the escrow has not yet been approved. The escrow must be approved for the money to be sent.') </div>
                    @endif

                    @if (($escrow->inventor_id != auth()->user()->id && $escrow->status == 0) ||  ($escrow->inventor_id != auth()->user()->id) )
                        @if ($escrow->status == 0 )
                            <a href="{{route('user.escrow.accepted',$escrow->id)}}" class="btn btn-success btn-sm mt-2 p-2 text-white" >@lang('Accept')</a>
                        @endif

                    @endif

                    @if ($escrow->status == 0)
                        @if($escrow->seller_id == auth()->user()->id || $escrow->buyer_id == auth()->user()->id)
                        <a href="{{route('user.escrow.cancel',$escrow->id)}}" class="btn btn--danger btn--sm mt-2 text-white" >@lang('Cancel')</a>
                        @endif
                    @endif

                    @if (($rest_amount <=0 ) && ($escrow->status == 2) && ($escrow->buyer_id == auth()->user()->id))
                        <a href="{{route('user.escrow.dispatch',$escrow->id)}}" class="btn btn-info btn-sm p-2 mt-2">@lang('Dispatch Payment')</a>

                    @endif

                    <!-- Button trigger modal -->
                    <a href="{{route('user.escrow.conversations',$escrow->id)}}" class="btn btn--base btn--sm mt-2">@lang('Conversations')</a>

                    </div>
                </div>
            </div>

                </div>
            </div>
        </div>
    </div>
</div>



{{-- modal --}}
<div class="modal fade" id="dispute" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Are you sure to dispute?')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{route('user.escrow.dispute')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-gorup">
                    <input type="hidden" name="id" >
                    <label for="">@lang('Remark')</label>
                    <textarea name="note" class="form--control" cols="15" rows="5" placeholder="@lang('Enter your reason')"></textarea>

                </div>
            </div>
            <div class="modal-footer">

              <button type="submit" class="btn btn--base btn--sm">@lang('Save')</button>
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
        $('.dispute').on('click', function () {
            var modal = $('#dispute');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush



