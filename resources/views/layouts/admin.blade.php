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
                return '{{ url('') }}/' + url
            }
        </script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
        {{ HTML::style('admin-assets/css/main.css') }}
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('admin') }}">Backend</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="{{ url('zgloszenia') }}" class="dropdown-toggle" data-toggle="dropdown">
                            {{-- @if (Entry2::countNew() > 0)
                                <span class="badge">{{ Entry2::countNew() }}</span>
                            @endif --}}
                        
                            Kuźnia <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="{{ url('zgloszenia2') }}">Zgłoszenia</a></li>
                            <!-- <li><a href="{{ url('zgloszenia/send') }}">Wyślij e-mail</a></li>-->
                            <!--<li><a href="{{ url('zgloszenia/questions') }}">Zobacz pytania</a></li>-->
                            <li><a href="{{ url('zgloszenia2/emails') }}"><i class="glyphicon glyphicon-download"></i> Pobierz listę e-maili</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="{{ url('admin/wampiriada') }}" class="dropdown-toggle" data-toggle="dropdown">
                            Wampiriada <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/wampiriada') }}"><i class="glyphicon glyphicon-signal"></i> Statystyki</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="navbar-text">{{ Auth::user()->username }}</li>
                    <li><a href="{{ url('logout') }}">Wyloguj</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                @if (Session::get('message'))
                    <div class="col-xs-12">
                        <div class="alert alert-{{ Session::get('status') }} alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{{ Session::get('message') }}}
                    </div>
                @endif
            </div>
        </div>

        <section class="container" role="main">
            @yield('content')
        </section>

        {{ HTML::script('bower_components/jquery/dist/jquery.min.js') }}
        {{ HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') }}
        {{ HTML::script('admin-assets/js/main.js') }}

        @yield('script')
    </body>
</html>
