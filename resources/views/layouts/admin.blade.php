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
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="text/javascript">
            function path(url) {
                return '{{ url('') }}/' + url
            }
        </script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
        {{ HTML::style('bower_components/font-awesome/css/font-awesome.min.css') }}

        {{ HTML::style('admin-assets/css/main.css') }}

        @yield('extrahead')
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
                            <li><a href="{{ url('admin/wampiriada') }}"><i class="glyphicon glyphicon-signal"></i> {{ NZS\Wampiriada\Editions\EditionRepository::current()->getEditionNumber() }}. edycja</a></li>
                            <li><a href="{{ url('admin/wampiriada/list') }}"><i class="glyphicon glyphicon-list"></i> Wszystkie edycje</a></li>
                            <li role="separator" class="divider"></li>

                            <li><a href="{{ url('admin/wampiriada/new') }}"><i class="glyphicon glyphicon-plus"></i> Dodaj nową edycję</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="{{ url('admin') }}" class="dropdown-toggle" data-toggle="dropdown">
                            Zarządzanie <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/email') }}"><i class="fa fa-envelope"></i> E-maile </a></li>
                            <li><a href="{{ url('admin/prize') }}"><i class="fa fa-star-o"></i> Nagrody </a></li>
                            <li><a href="{{ url('admin/mailing') }}"><i class="fa fa-envelope"></i> Mailingi </a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="navbar-text">{{ Auth::user()->person->getFullName() }}</li>
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

                @include('flash::message')
            </div>
        </div>

        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>

        <section class="container" role="main"  id="application">
            @yield('content')
        </section>

        {{ HTML::script('bower_components/jquery/dist/jquery.min.js') }}

        <script type="text/javascript">
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
        </script>

        @section('data')
            <script type="text/javascript">
                data = {}
            </script>
        @show

        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

        {{ HTML::script('admin-assets/js/main.js') }}

        @yield('script')
    </body>
</html>
