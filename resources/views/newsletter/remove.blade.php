@extends('layouts.master')

@section('title')
Wypisanie z powiadomień mailowych Wampiriady
@stop



@section('content')
    <section>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2>Wypisz się z powiadomień mailowych Wampiriady</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-4 col-sm-push-2 col-md-push-4 text-center">
                    <form class="form" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" name="email" id="email" value="{{ $email }}">
                        </div>

                        @include('recaptcha', ['action' => 'remove'])                      

                        <button class="btn btn-default" type="submit">Wypisz z powiadomień Wampiriady</button>
                    </form>

                </div>
            </div>
        </div>

    </section>

@stop
