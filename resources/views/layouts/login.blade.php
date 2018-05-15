<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>
            @yield('title')
        </title>
        <meta name="viewport" content="width=device-width">

        <script type="text/javascript">
            function path(url) {
                return '{{ url() }}/' + url
            }
        </script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
        {{ HTML::style('css/main.css') }}
    </head>
    <body>
        <section class="container" role="main">
            @yield('content')
        </section>

        {{ HTML::script('bower_components/jquery/dist/jquery.min.js') }}
        {{ HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') }}
        {{ HTML::script('js/main.js') }}

        @yield('script')
    </body>
</html>
