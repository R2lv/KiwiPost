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
    @stack('scripts:before')
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
    @include("templates/header-master")
@show

@yield("sections")

@section("news")
<section id="news" class="">
    <div class="news-list">
        @foreach($news as $n)
            <div class="news-view news-compact">
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

@section("slider")
<section id="slider" class="normal @yield('slider_type')">
    <div class="contentWrapper pad" style="padding: 0 50px;">
        <div class="slickSlider">
            @foreach($dataSlider['online_stores'] as $store)
                <div class="slide">
                    <a href="{{ $store['url'] }}" target="_blank"><img src="{{ $store['image'] }}" alt=""></a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="arrDown"></div>
</section>
@show

@section("footer")
    @include("templates/footer")
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

</body>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        // js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
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
        // js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=350637905398874';
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

</html>