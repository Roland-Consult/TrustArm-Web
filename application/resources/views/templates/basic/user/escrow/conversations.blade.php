@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard py-80 section-bg-two">
    <div class="container">
        <div class="row justify-content-center gy-4">
            <div class="col-md-6">
                <div class="card custom--card">

                    <div class="card custom--card">
                        <div class="card-header selling-header">
                            <h5 class="card-title">@lang('Replies')</h5>
                            <a href="" class="btn brn--base btn--sm"><i class="las la-redo-alt"></i></a>
                        </div>

                        <div class="card-body conversations-wrap" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">

                            @foreach ($messages as $item)

                                @if($item->sender_id == auth()->user()->id)

                                <div class="message-wrap">
                                    <ul class="list message-list message-right text-end">
                                        <div class="message-list__item">
                                            <div class="message-send">
                                                <div class="message-send__content section-bg-two">
                                                    <p class="message-send__text mb-0"> {{__($item->message)}}</p>
                                                </div>
                                                <ul class="list d-flex message-send__history  justify-content-end ">
                                                    <div class="message-receive__history-item">
                                                    {{($item->created_at)->format('h:i A')}}
                                                    </div>
                                                    <div class="message-receive__history-item">{{diffForHumans($item->created_at)}}</div>
                                                </ul>
                                            </div>
                                        </div>
                                    </ul>
                                </div>

                                @else

                                <div class="message-wrap">
                                    <ul class="list message-list message-left">
                                        <div class="message-list__item">
                                            <div class="message-send">
                                                <div class="message-send__content">
                                                    <p class="message-send__text mb-0"> {{__($item->message)}}</p>
                                                </div>
                                                <ul class="list d-flex message-send__history ">
                                                    <div class="message-receive__history-item">
                                                    {{($item->created_at)->format('h : i')}}
                                                    </div>
                                                    <div class="message-receive__history-item">{{diffForHumans($item->created_at)}}</div>
                                                </ul>
                                            </div>
                                        </div>
                                    </ul>
                                </div>


                                @endif

                            @endforeach
                        </div>

                        <form  method="post">
                            @csrf
                            <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">

                                @if ($escrow->status !=1)
                                    <input type="text" name="message" class="form--control form--control-lg" id="exampleFormControlInput1"
                                    placeholder="@lang('Type message ...')">
                                    <button class="ms-3" type="submit" ><i class="fas fa-paper-plane text--base"></i></button>
                                @endif


                                </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection
