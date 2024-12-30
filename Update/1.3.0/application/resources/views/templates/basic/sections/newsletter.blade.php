@php
    $newsletter = getContent('newsletter.content',true);
@endphp
<section class="subscribe-section section-bg py-40">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="subscribe-wrap text-center">
                    <h2>{{__($newsletter->data_values->heading)}}</h2>
                    <p>{{__($newsletter->data_values->subheading)}}</p>
                    <div class="subscribe-wrap__input">
                        <form action="{{route('subscribe')}}" method="POST">
                            @csrf

                        <input type="text" class="form--control" name="email" placeholder="@lang('Enter Your Mail')">
                        <button><i class="fas fa-paper-plane"></i></button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
