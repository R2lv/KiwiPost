<section id="head">
    <header class="upper">
        <a href="#" class="hamburger show-xs"></a>
        <ul class="nav horizontal left hide-xs">
            {{--<li @if(request()->is('/')) class="active" @endif><a href="/">@lang('defaults.home')</a></li>--}}
            <li @if(request()->is('about')) class="active" @endif><a href="/about" data-target="#how">@lang('defaults.aboutUs')</a></li>
            <li @if(request()->is('pricing')) class="active" @endif><a href="/pricing" data-target="#how">@lang('defaults.pricing')</a></li>
            <li @if(request()->is('shops')) class="active" @endif><a href="/shops" data-target="#how">@lang('defaults.shops')</a></li>
            <li @if(request()->is('faq')) class="active" @endif><a href="/faq">@lang('defaults.faqs')</a></li>
            <li @if(request()->is('news')) class="active" @endif><a href="/news" data-target="#how">@lang('defaults.news')</a></li>
        </ul>
        <a href="/" class="logo"></a>
        <ul class="nav horizontal right">
            <li @if(request()->is('concacts')) class="active" @endif><a style="font-weight: 600;"  href="/contacts">@lang('defaults.contactUs')</a></li>
            <li class="change-locale default-dropdown  dropdown hover">
                <div class="dropdown-handle">
                    <a href="#"><span class="image-flag @lang('defaults.active_flag')"></span>@lang('defaults.changeLocale')</a>
                    <span class="arr-down"></span>
                </div>
                <div class="dropdown-content with-caret lang-dropdown">
                    <a href="/lang/ka" class="@if(app()->getLocale() == 'ka') active @endif "><span class="image-flag flag-ge"></span> @lang('defaults.georgian')</a>
                    <a href="/lang/en" class="@if(app()->getLocale() == 'en') active @endif "><span class="image-flag flag-uk"></span> @lang('defaults.english')</a>
                </div>
            </li>
            <li><span class="location-icon"></span></li>
            <li><a href="#" class="sign-in-button" @click.prevent="showLoginWindow">@lang('defaults.signIn')</a></li>
            <li><a href="#" class="sign-up-button" @click.prevent="showRegistrationWindow">@lang('defaults.signUp')</a></li>
        </ul>
        <a href="#" class="sign-in-button show-xs upper" @click.prevent="showLoginWindow" v-cloak>@{{'sign_in'|translate}}</a>

    </header>
    <div id="navbar-drawer" class="show-xs geo upper">
        <ul>
            @auth
            <li>
                <a href="/">@lang('defaults.dashboard')</a>
            </li>
            @endauth
            @guest
            {{--<li>--}}
                {{--<a href="/">@lang('defaults.home')</a>--}}
            {{--</li>--}}
            @endguest

            <li>
                <a href="/about">@lang('defaults.aboutUs')</a>
            </li>
            <li>
                <a href="/pricing">@lang('defaults.pricing')</a>
            </li>
            <li>
                 <a href="/shops" data-target="#how">@lang('defaults.shops')</a>
            </li>
            <li>
                <a href="/faq">@lang('defaults.faqs')</a>
            </li>
            <li>
                <a href="/news">@lang('defaults.news')</a>
            </li>
            <li>
                <a href="/contacts">@lang('defaults.contactUs')</a>
            </li>
        </ul>

        <div class="lang-switch">
            <a href="/lang/ka" class="@if(app()->getLocale() == 'ka') active @endif "><span class="image-flag flag-ge large"></span></a>
            <a href="/lang/en" class="@if(app()->getLocale() == 'en') active @endif "><span class="image-flag flag-uk large"></span></a>
        </div>
    </div>
    <div class="mapWrapper mapSlider geo upper">
        {{--<div class="slider-arrow slider-left"></div>--}}
        @foreach($data['slider'] as $slider)
            <div class="map {{ $slider['image_class'] }} vAlignWrapper" data-height="500px">
                <div class="vAlign">
                    <h1 class="first-text">{{ $slider['line_1'] }}</h1>
                    <h1 class="second-text">{!!  $slider['line_2']  !!}</h1>
                    <div class="btn-wrapper" >
                        <div class="btn">
                            <button class="start upper" @click.prevent="showRegistrationWindow">{{ $slider['button_part_1'] }} <span class="green-text">{{ $slider['button_part_2'] }}</span></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{--<div class="map az vAlignWrapper" data-height="500px">--}}
            {{--<div class="vAlign">--}}
                {{--<h1 class="first-text">Shop Online</h1>--}}
                {{--<h1 class="second-text">And Ship Worldwide</h1>--}}
                {{--<div class="btn-wrapper">--}}
                    {{--<div class="btn">--}}
                        {{--<button class="start">Get started <span class="green-text">NOW</span></button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="slider-arrow slider-right"></div>--}}
    </div>
</section>