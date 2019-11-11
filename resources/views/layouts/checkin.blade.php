<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="pl"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="pl"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="pl"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pl"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>@yield('title')</title>
        <meta name="description" content="@yield('meta-description')">
        <meta name="viewport" content="width=device-width">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="57x57" href="{{ url('img/icons/apple-touch-icon-57x57.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ url('img/icons/apple-touch-icon-60x60.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ url('img/icons/apple-touch-icon-72x72.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ url('img/icons/apple-touch-icon-76x76.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ url('img/icons/apple-touch-icon-114x114.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ url('img/icons/apple-touch-icon-120x120.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ url('img/icons/apple-touch-icon-144x144.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ url('img/icons/apple-touch-icon-152x152.png') }}?v=allLWkmAnX">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ url('img/icons/apple-touch-icon-180x180.png') }}?v=allLWkmAnX">
        <link rel="icon" type="image/png" href="{{ url('img/icons/favicon-32x32.png') }}?v=allLWkmAnX" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ url('img/icons/android-chrome-192x192.png') }}?v=allLWkmAnX" sizes="192x192">
        <link rel="icon" type="image/png" href="{{ url('img/icons/favicon-96x96.png') }}?v=allLWkmAnX" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ url('img/icons/favicon-16x16.png') }}?v=allLWkmAnX" sizes="16x16">
        <link rel="manifest" href="{{ url('img/icons/manifest.json') }}?v=allLWkmAnX">
        <link rel="mask-icon" href="{{ url('img/icons/safari-pinned-tab.svg') }}?v=allLWkmAnX" color="#cb2b28">
        <link rel="shortcut icon" href="{{ url('img/icons/favicon.ico') }}?v=allLWkmAnX">
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="msapplication-TileImage" content="{{ url('img/icons/mstile-144x144.png') }}?v=allLWkmAnX">
        <meta name="msapplication-config" content="{{ url('img/icons/browserconfig.xml') }}?v=allLWkmAnX">
        <meta name="theme-color" content="#ffffff">

        <meta name="og:image" content="{{ url('img/wampir-logo-2.png') }}">

        <link rel="stylesheet" href="{{ app_mix('css/checkin.css') }}?r=6">
        <script type="text/javascript">
            function path(url) {
                return '{{ url('') }}/' + url
            }
        </script>
    </head>
    <body class="@yield('classes')">
        @yield('content')

        @yield('datajs')

        <script src="{{ app_mix('js/checkin.js') }}"></script>

        @include('layouts.templates.fb')

        @yield('extrajs')
    </body>
</html>
