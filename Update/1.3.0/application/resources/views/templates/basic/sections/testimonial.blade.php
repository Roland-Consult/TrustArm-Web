@php
    $testimonial = getContent('testimonial.content',true);
    $elements    = getContent('testimonial.element',false,10);
@endphp

<section class="testimonials py-80 section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <span class="section-heading__subtitle">{{__($testimonial->data_values->subheading)}}</span>
                    <h2 class="section-heading__title ">{{__($testimonial->data_values->heading)}} </h2>
                    <p class="section-heading__desc mb-30">{{__($testimonial->data_values->description)}}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">

            @foreach ($elements as $element)
            <div class="testimonails-card">
                <div class="testimonial-item">
                    <div class="testimonial-item__quate"><i class="fa-solid fa-quote-right"></i></div>
                    <div class="testimonial-item__content">
                        <div class="testimonial-item__info">
                            <div class="testimonial-item__thumb">
                                <img src="{{getImage(getFilePath('frontend').'/testimonial/'.$element->data_values->client_img)}}" alt="">
                            </div>
                            <div class="testimonial-item__details">
                                <h5 class="testimonial-item__name">{{__($element->data_values->name)}}</h5>
                                <span class="testimonial-item__designation">{{__($element->data_values->designation)}}</span>
                            </div>
                        </div>
                    <p class="testimonial-item__desc">{{__($element->data_values->description)}}</p>


                    <div class="testimonial-item__rating">
                        <ul class="rating-list">
                            @if($element->data_values->rating == 1)
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            @endif

                            @if($element->data_values->rating == 2)
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            @endif

                            @if($element->data_values->rating == 3)
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            @endif
                            @if($element->data_values->rating == 4)
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            @endif
                            @if($element->data_values->rating == 5)
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            @endif

                        </ul>
                    </div>
                </div>
                </div>
            </div>
            @endforeach

            {{-- <div class="testimonails-card">
                <div class="testimonial-item">
                    <div class="testimonial-item__quate"><i class="fa-solid fa-quote-right"></i></div>
                    <div class="testimonial-item__content">
                        <div class="testimonial-item__info">
                            <div class="testimonial-item__thumb">
                                <img src="assets/images/1__testimonials/testimonials-02.png" alt="">
                            </div>
                            <div class="testimonial-item__details">
                                <h5 class="testimonial-item__name">Hasan Robi</h5>
                                <span class="testimonial-item__designation">Web Developer</span>
                            </div>
                        </div>
                    <p class="testimonial-item__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur culpa magni, recusandae beatae provident nesciunt, quam corrupti rerum quod voluptatibus alias id!</p>


                    <div class="testimonial-item__rating">
                        <ul class="rating-list">
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
            <div class="testimonails-card">
                <div class="testimonial-item">
                    <div class="testimonial-item__quate"><i class="fa-solid fa-quote-right"></i></div>
                    <div class="testimonial-item__content">
                        <div class="testimonial-item__info">
                            <div class="testimonial-item__thumb">
                                <img src="assets/images/1__testimonials/testimonials-03.png" alt="">
                            </div>
                            <div class="testimonial-item__details">
                                <h5 class="testimonial-item__name"> Aliqua</h5>
                                <span class="testimonial-item__designation"> CEO & Founder</span>
                            </div>
                        </div>
                    <p class="testimonial-item__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur culpa magni, recusandae beatae provident nesciunt, quam corrupti rerum quod voluptatibus alias id!</p>


                    <div class="testimonial-item__rating">
                        <ul class="rating-list">
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
            <div class="testimonails-card">
                <div class="testimonial-item">
                    <div class="testimonial-item__quate"><i class="fa-solid fa-quote-right"></i></div>
                    <div class="testimonial-item__content">
                        <div class="testimonial-item__info">
                            <div class="testimonial-item__thumb">
                                <img src="assets/images/1__testimonials/testimonials-04.png" alt="">
                            </div>
                            <div class="testimonial-item__details">
                                <h5 class="testimonial-item__name">Humble Dowson</h5>
                                <span class="testimonial-item__designation">Head of Idea</span>
                            </div>
                        </div>
                    <p class="testimonial-item__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur culpa magni, recusandae beatae provident nesciunt, quam corrupti rerum quod voluptatibus alias id!</p>


                    <div class="testimonial-item__rating">
                        <ul class="rating-list">
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
