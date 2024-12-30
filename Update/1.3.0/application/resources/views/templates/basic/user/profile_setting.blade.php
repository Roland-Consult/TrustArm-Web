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
                        <div class="col-lg-12 ">
                            <div class="dashboard_profile text-center">
                                <div class="dashboard_profile__details">
                                    <div class="dashboard_profile_wrap">
                                        <div class="profile_photo mb-2">
                                            <img id="imageUpload" src="{{ getImage(getFilePath('userProfile').'/'.$user->image,getFileSize('userProfile')) }}" alt="agent">
                                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                            <div class="photo_upload">
                                                <label for="file_upload"><i class="fa-regular fa-image"></i></label>
                                                <input id="file_upload" type="file" name="image" class="upload_file"
                                                     onchange="this.form.submit()">
                                            </div>
                                           </form>
                                        </div>
                                        <div class="profile-details">
                                            <ul>
                                                <li>
                                                    <p><span>@lang('User Name'):</span> {{__($user->firstname)}} {{__($user->lastname)}}</p>
                                                    <p><span>@lang('Email'):</span> {{__($user->email)}}</p>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="user-profile">
                                <form class="register" action="" method="post" enctype="multipart/form-data">
                                    @csrf

                                        <div class="row gy-3">
                                            <div class="col-lg-12">
                                                <h4 class="mb-1">@lang('Personal Information')</h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name" class="form--label required"> @lang('First Name')</label>
                                                    <input type="text" class="form-control form--control" name="firstname"
                                                value="{{$user->firstname}}" required>

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="lastname" class="form--label required">@lang('Last  Name')</label>
                                                    <input type="text" class="form-control form--control" name="lastname"
                                                value="{{$user->lastname}}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email" class="form--label">@lang('Your Email') </label>
                                                    <input class="form-control form--control" value="{{$user->email}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label for="your-password" class="form--label">@lang('Phone')</label>
                                                    <input class="form-control form--control" value="{{$user->mobile}}" readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang('Address')</label>
                                                        <input type="text" class="form-control form--control" name="address"
                                                            value="{{@$user->address->address}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang('State')</label>
                                                        <input type="text" class="form-control form--control" name="state"
                                                            value="{{@$user->address->state}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="zip" class="form--label required"> @lang('Zip Code')</label>
                                                        <input type="text" class="form-control form--control" name="zip"
                                                            value="{{@$user->address->zip}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group ">
                                                        <label class="form-label">@lang('City')</label>
                                                        <input type="text" class="form-control form--control" name="city"
                                                            value="{{@$user->address->city}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang('Country')</label>
                                                        <input class="form-control form--control" value="{{@$user->address->country}}" disabled>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn--base w-100">@lang('Save Now')</button>
                                            </div>
                                        </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
