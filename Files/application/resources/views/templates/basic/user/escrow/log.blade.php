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
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>

                                            <th>@lang('Title')</th>
                                            <th>@lang('Category')</th>
                                            <th>@lang('Amount with Charge')</th>
                                            <th>@lang('Payer of Charges')</th>
                                            <th>@lang(' Number')</th>
                                            <th>@lang('Buyer - Seller')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('View')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($escrows as $key=>$item)
                                        <tr>

                                            <td data-label="Title"> {{__($item->title)}} </td>
                                            <td> {{__(@$item->category->name)}} </td>
                                            <td data-label="Amount">{{$general->cur_sym}} {{showAmount($item->amount + $item->charge)}}</td>
                                            <td data-label="Charge Payer">
                                                @if ($item->charge_sender ==1)
                                                @lang('Seller')
                                                @elseif($item->charge_sender ==2)
                                                @lang('Buyer')
                                                @else
                                                @lang('50% - 50%')
                                                @endif
                                            </td>
                                            <td>{{__($item->escrow_number)}}</td>

                                            <td>
                                                @if($item->seller_id == auth()->user()->id)
                                                <span>@lang('Selling to') {{_(@$item->buyer->username ??
                                                    $item->mail_invitation)}} </span>
                                                @else
                                                <span>@lang('Buying from') {{_(@$item->seller->username ??
                                                    $item->mail_invitation)}} </span>
                                                @endif
                                            </td>

                                            <td data-label="Action">
                                                @if($item->status == 0)
                                                <span class="badge badge--warning">@lang('Not Accepted')</span>
                                                @elseif($item->status == 1)
                                                <span class="badge badge--success">@lang('Dispatched')</span>
                                                @elseif($item->status == 2)
                                                <span class="badge badge--success">@lang('Accepted')</span>
                                                @elseif($item->status == 3)
                                                <span class="badge badge--primary">@lang('Disputed')</span>
                                                @else
                                                <span class="badge badge--danger">@lang('Canceled')</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{route('user.escrow.details',$item->id)}}"
                                                    class="tbl-btn--sm p-3"><i class="fas fa-eye"></i></a>
                                            </td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($escrows->hasPages())
                        <div class="">
                            {{ paginateLinks($escrows) }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
