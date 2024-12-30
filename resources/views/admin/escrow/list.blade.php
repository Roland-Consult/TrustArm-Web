@extends('admin.layouts.app')

@section('panel')
@include('admin.partials.tabs.escrow')
<div class="row justify-content-center gy-4">


    <div class="col-md-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Escrow Number')</th>
                                <th>@lang('Seller')</th>
                                <th>@lang('Buyer')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Payer of Charges')</th>

                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($escrows as $item)
                            <tr>

                                <td>{{__($item->title)}}</td>
                                <td>{{__($item->category->name)}}</td>
                                <td> {{__($item->escrow_number)}} </td>
                                <td>
                                    @if ($item->seller_id == 0)
                                        {{__($item->mail_invitation)}}
                                    @else
                                    {{__(@$item->seller->firstname)}} {{__(@$item->seller->lastname)}} <br>
                                    <a href="{{route('admin.users.detail',$item->seller->id)}}">@lang('@'){{__($item->seller->username)}}</a>

                                    @endif
                                </td>
                                <td>
                                    @if ($item->buyer_id == 0)
                                        {{__($item->mail_invitation)}}
                                    @else
                                        {{__($item->buyer->firstname)}} {{__($item->buyer->lastname)}} <br>
                                        <a href="{{route('admin.users.detail',$item->buyer->id)}}">@lang('@'){{__($item->buyer->username)}}</a>
                                    @endif
                                </td>
                                <td>{{$general->cur_sym}}{{showAmount($item->amount)}}</td>
                                <td>{{$general->cur_sym}}{{showAmount($item->charge)}}</td>
                                <td>
                                    @if ($item->charge_sender ==1)
                                        @lang('Seller')
                                    @elseif($item->charge_sender ==2)
                                        @lang('Buyer')
                                    @else
                                        @lang('Buyer (50%) - Seller(50%)')
                                    @endif
                                </td>

                                <td>
                                    @if($item->status == 0)
                                    <span class="badge bg-secondary">@lang('Not Accepted')</span>
                                    @elseif($item->status == 1)
                                    <span class="badge bg-info">@lang('Dispatched')</span>
                                    @elseif($item->status == 2)
                                    <span class="badge bg-success">@lang('Accepted')</span>
                                    @elseif($item->status == 3)
                                    <span class="badge bg-warning">@lang('Disputed')</span>
                                    @elseif($item->status == 4)
                                    <span class="badge bg-danger">@lang('Canceled')</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.escrow.details',$item->id)}}" class="btn btn-primary">@lang('Details')</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($escrows->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($escrows) }}
            </div>
            @endif

        </div><!-- card end -->
    </div>
</div>


@endsection


