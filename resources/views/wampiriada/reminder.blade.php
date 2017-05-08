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

            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-4 col-sm-push-2 col-md-push-4 text-center">
                    <form class="form" method="post">

                        {{ csrf_field() }}
                        @if($user->id)
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        @else
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="first_name">Imię</label>
                                <input type="text" class="form-control" name="first_name" id="first_name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Nazwisko</label>
                                <input type="text" class="form-control" name="last_name" id="last_name">
                            </div>
                        @endif

                        <button class="btn btn-default" type="submit">Ustaw przypomnienie</button>
                    </form>

                </div>
            </div>
        </div>

    </section>

@stop
