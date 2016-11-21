@extends('layouts.master')

@section('title')
Krew+ - akcja informująca o roli żelaza w Twoim życiu.
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
                    <h2><img src="{{ url('img/krewplus.png') }}" alt="Krew+"></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <p>Poniżej znajduje się <a download="krewplus.pdf" href="{{ url('materialy/krewplus.pdf') }}">elektroniczna wersja ulotki Krew+</a> informującej o funkcji żelaza w ograniźmie oraz o metodach dbania o właściwy poziom żelaza. Zapraszamy do zapoznania się z nią oraz do kontaktu z nami osobiście, jeśli interesuje Cię ten temat: <a href="mailto:nzs@nzs.lodz.pl">nzs@nzs.lodz.pl</a>.</p>
                </div>
            </div>
        </div>

    </section>

    <object type="application/pdf" data="{{ url('materialy/krewplus.pdf') }}" width="100%" height="100%">
        <p><a download="krewplus.pdf" href="{{ url('materialy/krewplus.pdf') }}">Pobierz ulotkę Krew Plus</a>.</p>
    </object>
@stop
