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

    <link rel="manifest" href="/manifest.json" />


</head>

<body class="hold-transition fixed skin-blue sidebar-mini @yield('body-class')">
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

    </div>
    <!-- ./wrapper -->
</div>
<script>
    window.__roles = @json($roles);
</script>
<script type="text/javascript" src="/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/admin/js/app.js"></script>
</body>
</html>
