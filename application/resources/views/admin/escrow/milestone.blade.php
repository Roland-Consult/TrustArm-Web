@extends('admin.layouts.app')

@section('panel')

<div class="row justify-content-center gy-4">


    <div class="col-md-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>

                            <tr>
                                <th>@lang('Short Note')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Payment Type')</th>
                                <th>@lang('Date')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($milestones as $item)
                                <tr>
                                    <td>{{$item->details}}</td>
                                    <td>{{showAmount($item->amount)}} {{$general->cur_text}} </td>
                                    <td>
                                        @if ($item->payment_type == 1)
                                            <span class="badge badge--success">@lang('Paid')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Unpaid')</span>
                                        @endif
                                    </td>
                                    <td>{{showDateTime($item->created_at)}}</td>
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
            @if ($milestones->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($milestones) }}
            </div>
            @endif

        </div><!-- card end -->
    </div>
</div>


@endsection

