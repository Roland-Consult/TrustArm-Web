@extends($activeTemplate.'layouts.frontend')
@section('content')



<section class="blog-detials py-60">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details">

                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <img src="{{__(getImage(getFilePath('frontend').'/blog/'.$blog->data_values->blog_image))}}"
                                alt="Blog-Image">
                        </div>
                        <div class="blog-item__content">
                            <ul class="text-list inline">
                                <li class="text-list__item"> <span class="text-list__item-icon"><i
                                            class="fas fa-user"></i></span> {{__($blog->data_values->author)}}</li>
                                <li class="text-list__item"> <span class="text-list__item-icon"><i
                                            class="fas fa-calendar-alt"></i></span>
                                    {{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="blog-details__content">
                        <h3 class="blog-details__title">{{__($blog->data_values->title)}}</h3>

                        <p class="blog-details__desc"> @php echo $blog->data_values->description; @endphp </p>


                        <div class="blog-details__share mt-4 d-flex align-items-center flex-wrap mb-4">
                            <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h5>
                            <ul class="social-list">
                                <li class="social-list__item"><a
                                        href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{slug($blog->data_values->title)}}"
                                        class="social-list__link"><i class="fab fa-facebook-f"></i></a> </li>
                                <li class="social-list__item"><a
                                        href="https://twitter.com/intent/tweet?status={{slug($blog->data_values->title)}}+{{ Request::url() }}"
                                        class="social-list__link active"> <i class="fab fa-twitter"></i></a></li>
                                <li class="social-list__item"><a
                                        href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{slug($blog->data_values->title)}}&source=propertee"
                                        class="social-list__link"> <i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog-sidebar-wrapper">
                    <div class="blog-sidebar">
                        <h5 class="blog-sidebar__title"> @lang('Most Recent Blogs ')</h5>
                        <span class="hr-line"></span>
                        <span class="border"></span>
                        @foreach ($latests as $item)
                        <div class="latest-blog">
                            <div class="latest-blog__thumb">
                                <a
                                    href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">
                                    <img src="{{__(getImage(getFilePath('frontend').'/blog/'.$item->data_values->blog_image))}}"
                                        alt=""></a>
                            </div>
                            <div class="latest-blog__content">
                                <h6 class="latest-blog__title"><a
                                        href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">{{__($item->data_values->title)}}</a>
                                </h6>
                                <span class="latest-blog__date">{{\Carbon\Carbon::parse($blog->created_at)->format('d M
                                    Y')}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection