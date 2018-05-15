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

        <link rel="stylesheet" href="{{ app_mix('css/main.css') }}">
        <script type="text/javascript">
            function path(url) {
                return '{{ url('') }}/' + url
            }
        </script>
    </head>
    <body class="@yield('classes')">

 <div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    FB.init({
      appId      : '830027050436250',
      xfbml      : true,
      version    : 'v2.6'
    });

    @yield('extrafb')
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

</script>

        @yield('content')

		<!--skrypty z map google-->
        <script src="{{ app_mix('js/main.js') }}"></script>

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&key=AIzaSyCL7ZBHNxksuMm90Rua5BXpeu4yEze3P8I"></script>
		<script type="text/javascript" src="{{ url('bower_components/gmaps/gmaps.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower_components/isotope/dist/isotope.pkgd.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower_components/jquery.scrollTo/jquery.scrollTo.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower_components/handlebars/handlebars.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/vendor/canvasjs/canvasjs.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower_components/responsive-bootstrap-toolkit/dist/bootstrap-toolkit.min.js') }}"></script>

        <script src="http://accept-cookie.cdn.lambdadelta.pl/jquery.accept-cookie.js"></script>

        @yield('extrajs')
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-36686663-3'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
