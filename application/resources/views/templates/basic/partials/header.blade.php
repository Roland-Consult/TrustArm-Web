@php
    $pages   = App\Models\Page::get();
    $languages = App\Models\Language::all();
@endphp
<div class="header-area">
    <div class="header" id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand logo" href="{{route('home')}}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt=""></a>
                <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span id="hiddenNav"><i class="las la-bars"></i></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-menu ms-auto">



                        @foreach ($pages as $page)

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('pages', $page->slug) }}">{{ __($page->name)
                            }}</a>
                        </li>

                        @endforeach


                        @guest
                        <li class="nav-item">
                            <div class="language-box">
                                <select class="select language-select">
                                    @foreach ($languages as $lang)
                                        <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </li>
                        <li class="nav-item btn-style">
                            <a class="nav-link btn btn--base style-1" href="{{route('user.login')}}">@lang('Sign In / Sign Up')</a>
                        </li>
                        @endguest

                        @auth
                        <li class="nav-item">
                            <a class="nav-link"
                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                        </li>
                        <li class="nav-item">
                            <div class="language-box">
                                <select class="select language-select">
                                    @foreach ($languages as $lang)
                                        <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </li>
                        @endauth

                        @auth
                        <li class="nav-item btn-style">
                            <a class="nav-link btn btn--base style-1" href="{{route('user.logout')}}">@lang('Sign Out')</a>
                        </li>
                        @endauth

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

