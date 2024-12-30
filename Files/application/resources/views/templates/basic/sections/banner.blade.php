@php
$banner = getContent('banner.content',true);
$categories = App\Models\Category::where('status',1)->get();
@endphp

<section class="banner-area section-bg">
  <div class="shapes">

    <img class="shape shape-1 animate-y-axis"
      src="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->animation_img1)}}" alt="agreement">

    <img class="shape shape-6 animate-y-axis"
      src="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->animation_img2)}}" alt="coin">

    <img class="shape shape-3 eight"
      src="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->animation_img3)}}" alt="third_party">

    <img class="shape shape-7 animate-y-axis"
      src="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->animation_img4)}}" alt="third_party">

  </div>
  <div class="container">
    <div class="row gy-4 align-items-center justify-content-center">
      <div class="col-lg-6">
        <div class="banner__content">
          <h2>{{__($banner->data_values->heading)}}</h2>
          <p>{{__($banner->data_values->subheading)}}</p>
          <button class="btn btn--base">{{__($banner->data_values->button)}}</button>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="banner-form-wrap">
          <div class="contactus-form">
            <h3 class="contact__title"> @lang('Safe, Secure, and Efficient')</h3>
            <form action="{{route('user.escrow.info')}}" autocomplete="off">
              @csrf
              <div class="row gy-md-4 gy-3">
                <div class="col-sm-12">
                  <select class="select form--control">

                    <option selected="" value="1">@lang('I Am Selling')</option>
                    <option value="2">@lang('I Am Buying')</option>
                  </select>
                </div>
                <div class="col-sm-12">
                  <select class="select form--control">
                    @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{__($item->name)}}</option>
                    @endforeach


                  </select>
                </div>
                <div class="col-sm-12">
                  <input type="text" class="form--control" placeholder="For the Amount Of {{ $general->cur_text }}">
                </div>
                <div class="col-sm-12">
                  <button class=" btn btn--base"> @lang('Continue')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>