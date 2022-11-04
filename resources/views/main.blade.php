<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    @isset($data)
    <script>
        window.data = @json($data);
    </script>
    @endisset
    <script src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}" async defer></script>
    <script type="text/javascript" async defer src="/js/app.js"></script>
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('fb-title')">
    <meta property="og:description" content="@yield('fb-description')">
    <meta property="fb:app_id" content="350637905398874">
    <meta property="og:image" content="@yield('fb-image')">

    <meta name="description" content="ამანათები, საფოსტო გადაზიდვები ინგლისი ლონდონი საქართველო" >
    <meta name="keywords" content="გადაზიდვები,transfer,ამანათები,parcels,საფოსტო,post,გადაზიდვები,move,ინგლისი,England,საქართველო,Georgia,ამანათი,parcel,ფოსტა,post,delivery,deliver,send,receive,pack,packed,Postage,sendparceltogeorgia,parceltogeorgia,worldwideparcelservice,შოპინგები,შოპინგი,Shopping,Onlineshopping,internet,internetshopping,შოპინგი,შოპინგები,ონლაინშოპინგები,ინტერნეტშოპინგი,გამოწერაინგლისიდან,ტანსაცმელიდააქსესუარებიინგლისიდან">

    <meta name="google-site-verification" content="nU0vEKoqcpcNJh53dJMi8SXqJxmBfReTbUC_1DQ9YT0" />


    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "ab3f9286-e796-478b-8d82-11b268f7a01b",
                autoRegister: true,
                notifyButton: {
                    enable: true,
                },
            });
        });
    </script>

</head>
<body class="{{app()->getLocale()}}" lang="{{app()->getLocale()}}">
<div id="app">
@section("header")
    @include("templates/header-main")
@show

@yield("contents")


@section("slider")
<section id="slider" class="slider-main">
    <div class="contentWrapper pad" style="padding: 0 50px;">
        <div class="slickSlider">
            @foreach($data['online_stores'] as $store)
                <div class="slide">
                    <a href="{{ $store['url'] }}" target="_blank"><img src="{{ $store['image'] }}" alt=""></a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@show
@section('whyKiwi')
<section id="why-kiwi" class="geo lower">
    <div class="skew-wrapper">
        <div class="skew">
            <div class="contentWrapper geo upper">
                {{--<p class="about-text">@lang('pages.pricing.page_text')</p>--}}
                <div class="why-kiwi-title">{{ $data['why_us']['title'] }}</div>
                <div class="why-blocks">
                    @foreach($data['why_us']['bullet_points'] as $point)
                        <div class="why-block">
                            <div class="image">
                                <img src="{{ $point['image_url'] }}" alt="">
                            </div>
                            <div class="block-footer">
                                <div class="title">
                                    {{ $point['title'] }}
                                </div>
                                <div class="mini-title">
                                     {!!  $point['description']  !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>

@show
@section("video")
<section id="video">
    <div class="close">X</div>
    <div class="skew-wrapper video-skew-wrapper">
        <div class="skew">
            <div class="video">
                <video src="/preview.mp4" loop autoplay muted onloadedmetadata="this.muted=true"></video>
            </div>
            <div class="overlay">
                <div class="contentWrapper">
                    <div class="play-block vAlign geo upper">
                        <div class="text">
                            <span class="top">@lang('pages.home.play')</span>
                            <span class="bottom">@lang('pages.home.video')</span>
                        </div>
                        <div class="divider"> </div>
                        <div class="play-button"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@show

@section("calculator")
<section id="calculator">
    <div id="calc-skew-wrapper">
        <div id="calc-skew">
            <div class="contentWrapper">
                <div class="left-block geo upper">
                    <calculator></calculator>
                </div>
            </div>
        </div>
    </div>
</section>
@show

@section("news")
<section id="news" class="">
        <div class="news-list">
            @foreach($news as $n)
                <div class="news-view news-compact geo upper">
                    <a style="color: inherit;" href="/news/{{ $n->id }}"><div class="bg" style="background-image: url('{{ $n->image_url }}')"></div></a>
                    <div>
                        <div class="date">{{ $n->date }}</div>
                        <div class="title"><a style="color: inherit;" href="/news/{{ $n->id }}">{{ $n->title }}</a></div>
                    </div>
                </div>
            @endforeach
        </div>
</section>
@show

@section("how")
<section id="how">
    <div class=" how-it-works">
        {{--<div class="skew">--}}
            <div class="contentWrapper geo upper">
                <div class="how-title upper">{!!  $data['how_to_use']['title']  !!}</div>

                <div class="blocks geo upper">
                    @foreach($data['how_to_use']['bullet_points'] as $point)
                        <div class="block">
                            <div class="icon"><img src="{{ $point['image_url'] }}" alt=""></div>
                            <div class="title upper">{{ $point['title'] }}</div>
                            <p class="text geo lower">{!!  $point['description']  !!}</p>

                            <a href="{{ $point['button_url'] }}" class="btn">{{ $point['button_title'] }}</a>
                            <div class="connector"></div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                    <!--<div class="connector"></div>-->
                </div>
            </div>
        {{--</div>--}}
    </div>
</section>
@show

@section("footer")
    @include('templates.footer')
@show
</div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109728602-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-109728602-1');
</script>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '350637905398874',
            xfbml      : true,
            version    : 'v2.12'
        });

        FB.AppEvents.logPageView();

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


<div style="display: none;" id="alertBosMessage">
    {{ app('request')->input('alert')}}
</div>
</body>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     page_id="457401257954531"
     theme_color="#13cf13"
     logged_in_greeting="@lang('defaults.fb-messages.welcome')"
     logged_out_greeting="@lang('defaults.fb-messages.welcome')">
</div>


<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<script>
    $(document).ready(function() {

    });

</script>

</html>

