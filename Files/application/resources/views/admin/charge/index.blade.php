@extends('admin.layouts.app')
@section('panel')

<div class="row mb-none-30">
    <div class="col-lg-6 col-md-12 mb-30">
        <div class="card">
            <div class="card-body px-4">
                <form action="{{route('admin.generalCharge')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="charge">@lang('Fixed Charge')</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text currency">$</span>
                                </div>
                                <input type="number" name="generalFixed" class="form-control" value="{{getAmount($general->fixed_charge)}}" aria-label="Amount (to the nearest dollar)">

                            </div>
                        </div>

                        <div class="col-12">
                            <label for="charge">@lang('Percent Charge ') (%)</label>
                            <div class="input-group mb-3">

                                <input type="text" name="generalPercent" class="form-control" value="{{getAmount($general->percent_charge)}}" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency">%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-global ">@lang('Update')</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body px-4">
                <form action="{{route('admin.escrowCharge')}}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-6">
                            <label for="charge">@lang('Minimum') <span class="text-danger">@lang('(If the amount falls within any range)')</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text currency">$</span>
                                </div>
                                <input type="number" name="minimum" class="form-control" value="{{getAmount($escrowCharge->minimum)}}" aria-label="Amount (to the nearest dollar)">

                            </div>
                        </div>

                        <div class="col-6">
                            <label for="charge">@lang('Maximum')  <span class="text-danger">@lang(' (If the amount falls within any range)')</span> </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text currency">$</span>
                                </div>
                                <input type="number" name="maximum" class="form-control" value="{{getAmount($escrowCharge->maximum)}}" aria-label="Amount (to the nearest dollar)">

                            </div>
                        </div>

                        <div class="col-6">
                            <label for="charge">@lang('Fixed Charge')</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text currency">$</span>
                                </div>
                                <input type="number" name="fixed" class="form-control" value="{{getAmount($escrowCharge->fixed_charge)}}" aria-label="Amount (to the nearest dollar)">

                            </div>
                        </div>

                        <div class="col-6">
                            <label for="charge">@lang('Percent Charge') (%)</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" name="percent" value="{{getAmount($escrowCharge->percent_charge)}}" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency ">%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-global ">@lang('Update')</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('style')
<style>
span.input-group-text.currency {
    padding: 7px 0.75rem;
    border-radius: 0.25rem 0 0 0.25rem;
}
</style>


@endpush
