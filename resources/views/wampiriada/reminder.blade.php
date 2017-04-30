@extends('layouts.master')

@section('title')
Dodaj przypomnienie - Wampiriada
@stop

@section('meta-description')
Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.
@stop

@section('content')
    {{-- @include('wampiriada.templates.header') --}}

    <section>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2>Przypomnij mi e-mailowo o akcji Wampiriady</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-center">
                    <p style="font-size: 2em; margin: 40px 0">
                        <strong>
                        {{ $action->place }}
                        </strong>
                    <br>

                    {{ $action->day->format('d.m.Y') }}, godz. {{ $action->start->format('H:i') }} - {{ $action->end->format('H:i') }}

                    @if($action->marrow)
                        <br>+ SZPIK TO ME
                    @endif

                    </p>
                </div>
                <div class="col-xs-12 col-md-6 text-center col-md-push-3">
                    <p>Wyślemy Ci e-maila z przypomnieniem na 2 dni przed akcją. :)</p>
                </div>


                <div class="col-xs-12 text-center">
                    <form class="form" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button class="btn btn-default" type="submit">Ustaw przypomnienie</button>
                    </form>

                </div>
            </div>
        </div>

    </section>

@stop
