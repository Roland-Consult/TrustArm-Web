@php
    $partner = getContent('partner.content',true);
    $elements = getContent('partner.element',false);
@endphp

<div class="client py-60 ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <span class="section-heading__subtitle"> {{__($partner->data_values->subheading)}} </span>
                    <h2 class="section-heading__title ">{{__($partner->data_values->heading)}} </h2>
                    <p class="section-heading__desc mb-30"> {{__($partner->data_values->description)}} </p>
                </div>
            </div>
        </div>

        <div class="client-logos client-slider">
            @foreach ($elements as $element)
            <img src="{{__(getImage(getFilePath('frontend').'/partner/'.$element->data_values->partner_img))}}" alt="">
            @endforeach
            
        </div>
    </div>
</div>
