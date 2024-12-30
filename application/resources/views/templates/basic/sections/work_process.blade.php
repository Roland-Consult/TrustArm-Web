@php
$workProcess = getContent('work_process.content',true);
@endphp

<section class="how-work-area py-80">
    <div class="container">
        <div class="row gy-5 align-items-center flex-wrap-reverse">
            <div class="col-lg-6">
                <div class="how-work-content">
                    <div class="section-heading mb-0">
                        <span class="section-heading__subtitle">{{__($workProcess->data_values->subheading)}}</span>
                        <h2 class="section-heading__title ">{{__($workProcess->data_values->heading)}} </h2>
                        <p class="section-heading__desc mb-30">{{__($workProcess->data_values->description)}}</p>
                        <div class="how-work-content__hork-items">
                            <ul>
                                <li>
                                    <h6><i class="fa-solid fa-users"></i>{{__($workProcess->data_values->purchaser)}}
                                    </h6>
                                    <h6><i
                                            class="fa-solid fa-paper-plane"></i>{{__($workProcess->data_values->goodsOrService)}}
                                    </h6>
                                </li>
                                <li>
                                    <h6><i class="fa-solid fa-money-bill-1-wave"></i>
                                        {{__($workProcess->data_values->paymentToSeller)}}</h6>
                                    <h6><i class="fa-solid fa-credit-card"></i>
                                        {{__($workProcess->data_values->dischargesInstallment)}}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="how-work">
                    <div class="how-work__thumb">
                        {{-- <img src="assets/images/how-work/how-work.png" alt="images"> --}}
                        <img src="{{getImage(getFilePath('frontend').'/work_process/'.$workProcess->data_values->work_process_img)}}"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>