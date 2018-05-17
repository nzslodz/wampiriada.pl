@extends('layouts.master')

@section('title')
Wampiriada w Łodzi
@stop

@section('meta-description')
Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.
@stop

@section('content')
    @include('wampiriada.templates.header')

    <section>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2><img src="{{ url('img/szpiktome.png') }}" alt="Szpik to Me"></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <p>Poniżej znajduje się <a download="szpiktome.pdf" href="{{ url('materialy/szpiktome-11.pdf') }}">elektroniczna wersja ulotki Szpik to Me</a> informującej o zostaniu honorowym dawcą szpiku kostnego. Zapraszamy do zapoznania się z nią oraz do kontaktu z nami osobiście, jeśli interesuje Cię ten temat: <a href="mailto:nzs@nzs.lodz.pl">nzs@nzs.lodz.pl</a>.</p>
                </div>
            </div>

        </div>

    </section>

    <object type="application/pdf" data="{{ url('materialy/szpiktome-11.pdf') }}" width="100%" height="100%">
        <p><a download="krewplus.pdf" href="{{ url('materialy/szpiktome-11.pdf') }}">Pobierz ulotkę Szpik to Me</a>.</p>
    </object>

@stop
