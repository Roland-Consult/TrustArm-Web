@php
   $blog = getContent('blog.content',true);
   $elements = getContent('blog.element',false,6);
@endphp

<section class="blog py-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <span class="section-heading__subtitle">{{__($blog->data_values->subheading)}}</span>
                    <h2 class="section-heading__title "> @php echo $blog->data_values->heading; @endphp </h2>
                    <p class="section-heading__desc mb-30"> {{__($blog->data_values->description)}} </p>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            @foreach ($elements as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-item__thumb">
                        <a href="{{ route('blog.details', ['slug' => slug($blog->data_values->title), 'id' => $blog->id])}}" class="blog-item__thumb-link">
                            <img src="{{__(getImage(getFilePath('frontend').'/blog/'.$blog->data_values->blog_image))}}" alt="">
                        </a>
                    </div>
                    <div class="blog-item__content">
                        <ul class="text-list inline">
                            <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-user"></i></span> {{__($blog->data_values->author)}} </li>
                            <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span> {{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}} </li>
                        </ul>
                        <h4 class="blog-item__title"><a href="{{ route('blog.details', ['slug' => slug($blog->data_values->title), 'id' => $blog->id])}}" class="blog-item__title-link">{{__($blog->data_values->title)}}</a></h4>
                        <a href="{{ route('blog.details', ['slug' => slug($blog->data_values->title), 'id' => $blog->id])}}" class="btn--simple">{{__($blog->data_values->button)}} <span class="btn--simple__icon"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
