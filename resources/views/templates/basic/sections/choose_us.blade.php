@php
$choose_us = getContent('choose_us.content',true);
$elements = getContent('choose_us.element',false,4);
@endphp

<section class="why-choose-us py-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <span class="section-heading__subtitle">{{__($choose_us->data_values->subheading)}}</span>
                    <h2 class="section-heading__title ">{{__($choose_us->data_values->heading)}}</h2>
                    <p class="section-heading__desc mb-30">{{__($choose_us->data_values->description)}}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach($elements as $element)
            <div class="col-lg-4 col-md-6">
                <div class="product text-center">
                    <img class="dot-image" src="{{ getImage($activeTemplateTrue.'/images/why-choose/image-dots.png') }}"
                        alt="">
                    <img class="dot-image-left"
                        src="{{ getImage($activeTemplateTrue.'/images/why-choose/image-dots.png') }}" alt="">
                    <div class="product__thumb">

                        <img src="{{getImage(getFilePath('frontend').'/choose_us/'.$element->data_values->choose_img)}}"
                            alt="">
                    </div>
                    <div class="product__content">
                        <h3 class="title">{{__($element->data_values->title)}}</h3>
                        <p>{{__($element->data_values->description)}}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>