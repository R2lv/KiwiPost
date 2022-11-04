<section id="head" class="tiny">
    <header class="geo upper">
        <a href="#" class="hamburger show-xs"></a>
        <ul class="nav horizontal left">
            <li @if(request()->is('about')) class="active" @endif><a href="/about" data-target="#how">@lang('defaults.aboutUs')</a></li>
            <li @if(request()->is('pricing')) class="active" @endif><a href="/pricing" data-target="#how">@lang('defaults.pricing')</a></li>
            <li @if(request()->is('shops')) class="active" @endif><a href="/shops" data-target="#how">@lang('defaults.shops')</a></li>
            <li @if(request()->is('faq')) class="active" @endif><a href="/faq" data-target="#how">@lang('defaults.faqs')</a></li>
            <li @if(request()->is('news')) class="active" @endif><a href="/news"  data-target="#how">@lang('defaults.news')</a></li>

        </ul>
        <a href="/" class="logo"></a>
        <ul class="nav horizontal right">
            <li @if(request()->is('contacts')) class="active" @endif><a style="font-weight: 600;" href="/contacts" >@lang('defaults.contactUs')</a></li>
            <li class="change-locale default-dropdown dropdown hover">
                <div class="dropdown-handle">
                    <a href="#"><span class="image-flag @lang('defaults.active_flag')"></span>@lang('defaults.changeLocale')</a>
                    <span class="arr-down"></span>
                </div>
                <div class="dropdown-content with-caret with-shadow lang-dropdown">
                    <a href="/lang/ka" class="@if(app()->getLocale() == 'ka') active @endif "><span class="image-flag flag-ge"></span> @lang('defaults.georgian')</a>
                    <a href="/lang/en" class="@if(app()->getLocale() == 'en') active @endif "><span class="image-flag flag-uk"></span> @lang('defaults.english')</a>
                </div>
            </li>
            <li><span class="location-icon"></span></li>
            @auth
            <li class="name">
                <a href="#" style="border-bottom-color: transparent !important;">@lang('defaults.hello'), {{Auth::user()->name}}!</a>
            </li>
            <li class="image default-dropdown dropdown hover">
                <a href="#" class="dropdown-handle">
                    <img src="/images/profile.png" alt="">
                    <div class="notification hidden"></div>
                </a>
                <div class="dropdown-content with-caret with-shadow">
                    <a href="#" class="hidden">Messages <span class="addon msg-length">4</span></a>
                    @if(auth()->user()->roles > 0)
                        <a href="{{ route('cms', ['all'=>'home']) }}">@lang('defaults.cms')</a>
                    @endif
                    @if(auth()->user()->roles == -5)
                        <a target="_blank" href="{{ route('excel') }}">Export</a>
                    @endif
                    @if(auth()->user()->id == 1 || auth()->user()->id == 3)
                        <a target="_blank" href="{{ route('excel') }}">Export UK-GEO</a>
                        <a target="_blank" href="{{ route('excelFromGeo') }}">Export GEO-UK</a>
                    @endif

                    <a href="#" @click.prevent="showProfileEditWindow">@lang('defaults.options') <span class="addon"><img src="images/profile-options-icon.png" alt=""></span></a>
                    <a href="/logout" class="logout-text">@lang('defaults.logOut') <span class="addon"><img src="images/profile-logout-icon.png" alt=""></span></a>
                </div>
            </li>
            @endauth

            @guest
            <li><a href="#" class="sign-in-button" @click.prevent="showLoginWindow">@lang('defaults.signIn')</a></li>
            <li><a href="#" class="sign-up-button" @click.prevent="showRegistrationWindow">@lang('defaults.signUp')</a></li>
            @endguest
        </ul>
        @guest
        <a href="#" class="sign-in-button show-xs upper" @click.prevent="showLoginWindow" v-cloak>@{{'sign_in'|translate}}</a>
        @endguest
        @auth
        <div class="show-xs dropdown default-dropdown">
            <a href="#" class="profile-button dropdown-handle">
                <img src="/images/profile.png" alt="">
                <div class="notification hidden"></div>
            </a>
            <div class="dropdown-content with-caret with-shadow">
                <a href="#" class="hidden">Messages <span class="addon msg-length">4</span></a>
                @if(auth()->user()->roles > 0)
                    <a href="{{ route('cms', ['all'=>'home']) }}">@lang('defaults.cms')</a>
                @endif
                <a href="#" @click.prevent="showProfileEditWindow">@lang('defaults.options') <span class="addon"><img src="images/profile-options-icon.png" alt=""></span></a>
                <a href="/logout" class="logout-text">@lang('defaults.logOut') <span class="addon"><img src="images/profile-logout-icon.png" alt=""></span></a>
            </div>
        </div>
        @endauth
    </header>

    <div id="navbar-drawer" class="show-xs geo upper">
        <ul>
            @auth
            <li>
                <a href="/">@lang('defaults.dashboard')</a>
            </li>
            @endauth
            {{--@guest--}}
            {{--<li>--}}
                {{--<a href="/">@lang('defaults.home')</a>--}}
            {{--</li>--}}
            {{--@endguest--}}
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
</section>