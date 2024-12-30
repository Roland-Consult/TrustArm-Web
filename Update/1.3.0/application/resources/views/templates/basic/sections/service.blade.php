@php
$service = getContent('service.content',true);
// $elements = getContent('service.element',false,4);
$categories = App\Models\Category::where('status',1)->get();
@endphp

<section class="services py-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <span class="section-heading__subtitle">{{__($service->data_values->subheading)}}</span>
                    <h2 class="section-heading__title ">{{__($service->data_values->heading)}}</h2>
                    <p class="section-heading__desc mb-30">{{__($service->data_values->description)}}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">

            @foreach($categories->slice(0,8) as $category)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="product text-center">
                    <img class="dot-image" src="{{ getImage($activeTemplateTrue.'/images/why-choose/image-dots.png') }}"
                        alt="">
                    <img class="dot-image-left"
                        src="{{ getImage($activeTemplateTrue.'/images/why-choose/image-dots.png') }}" alt="">
                    <div class="product__thumb">

                        @php
                        echo $category->icon;
                        @endphp
                    </div>
                    <div class="product__content">
                        <h3 class="title">{{__($category->name)}}</h3>

                          <p> @if(strlen(strip_tags(__($category->description))) > 50)
                            {{ substr(strip_tags(__($category->description)), 0, 50) . '...' }}
                            @else
                                {{ strip_tags(__($category->description)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>