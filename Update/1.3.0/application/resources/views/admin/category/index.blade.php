@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('SL')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $key=>$item)
                            <tr>
                                <td> {{__(++$key)}} </td>
                                <td> {{__($item->name)}} </td>
                                <td>
                                    @if($item->status == 1)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Deactive')</span>
                                    @endif

                                </td>
                                <td>

                                    <button class="btn btn-sm btn--primary addBtn" data-resource="{{$item}}" data-id="{{$item->id}}" data-name="{{$item->name}}" data-description="{{$item->description}}" data-image="{{$item->image}}"><i class="las la-pen-square"></i></button>

                                    @if($item->status == 0)
                                        <button title="@lang('Enable')"
                                            class="btn btn-sm btn--success ms-1 confirmationBtn"
                                            data-question="@lang('Are you sure to enable this category?')"
                                            data-action="{{ route('admin.category.active',$item->id) }}">
                                            <i class="la la-check-circle"></i>
                                        </button>
                                        @else
                                        <button title="@lang('Disable')"
                                            class="btn btn-sm btn--danger ms-1 confirmationBtn"
                                            data-question="@lang('Are you sure to disable this category?')"
                                            data-action="{{ route('admin.category.deactive',$item->id) }}">
                                            <i class="la la-eye-slash"></i>
                                        </button>
                                        @endif

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>

{{-- Add METHOD MODAL --}}
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Category')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.category.list')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="">
                        <label> @lang('Category Name')</label>
                        <input type="text" class="form-control name" name="name" value="{{old('name')}}" required>
                    </div>

                    <div class="form-group">

                        <label> @lang('Short Description')</label>
                        <input type="text" class="form-control name" name="description" value="{{old('description')}}" required>
                    </div>


                    <div class="form-group">
                        <label for="social_icon" class="required">@lang('Select Icon')</label>
                        <div class="input-group iconpicker-container">
                            <input type="text" class="form-control iconPicker icon iconpicker-element iconpicker-input" autocomplete="off" name="icon" required="" id="social_icon">
                            <span class="input-group-text  input-group-addon" data-icon="las la-home" role="iconpicker"><i class=""></i></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-confirmation-modal></x-confirmation-modal>

@endsection

@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn--primary addBtn"><i class="las la-plus"></i>@lang('Add
    New')</button>

@endpush

@push('style-lib')
<link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
<script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush

@push('script')

<script>
    (function ($) {
        "use strict";

        $('.addBtn').on('click', function () {
            var modal = $('#addModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.find('input[name=name]').val($(this).data('name'))
            modal.find('input[name=description]').val($(this).data('description'))

            modal.modal('show');
        });

        $('.iconPicker').iconpicker().on('iconpickerSelected', function (e) {
            $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
        });

    })(jQuery);

</script>

@endpush
