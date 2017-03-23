<!DOCTYPE html>
<html lang="en">
<head>
    <meta  http-equiv="content-type" content="text/html;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="robots" content="none">
    <title>@yield('title')</title>
    <link href="{{ URL::asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    @yield('self_head')
</head>
    @yield('content')
    <!-- 全局js -->
    <script src="{{ URL::asset('/js/jquery.min.js?v=2.1.4') }}"></script>
    <script src="{{ URL::asset('/js/bootstrap.min.js?v=3.3.6') }}"></script>
    <script src="{{ URL::asset('/js/plugins/layer/layer.min.js') }}"></script>
    @yield('self_js')
</html>