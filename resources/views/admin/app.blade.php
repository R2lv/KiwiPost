<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/admin/css/app.css">

    <script type="text/javascript" src="/admin/js/app.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini @yield('body-class')">
<div id="app">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include ('admin.layouts.header')

        @include ('admin.layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->

            <router-view></router-view>
        {{--@yield ('content')--}}

        <!-- /.content-wrapper -->
        @include ('admin.layouts.footer')

        @if(auth()->user()->roles > 30)
            @include ('admin.layouts.options')
        @endif

    </div>
    <!-- ./wrapper -->
</div>
</body>
<script type="application/ld+json">
{
"@context": "https://kiwipost.ge",
"@type": "Organization",
"url": "https://www.kiwipost.ge",
"logo": "https://kiwipost.ge/images/logo.png"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://kiwipost.ge",
  "@type": "Organization",
  "name": "Kiwi Post",
  "url": "https://kiwipost.ge",
  "sameAs": [
    "https://www.facebook.com/kiwipost",
    "https://www.instagram.com/kiwipost/",
  ]
}
</script>
</html>
