@extends('layouts.master')

@section('title')
Wampiriada w Łodzi
@stop

@section('meta-description')
Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.
@stop

@section('content')
<section id="intro">
    <div class="container-fluid sr-only">
    <div class="row invisible">
        <div class="col-xs-12">
            <h1>Wampiriada - studenckie honorowe krwiodawstwo</h1>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-xs-12 movie">
            <h2>Poznaj Wampira</h2>
            <div class="box">
                <iframe width="853" height="480" src="//www.youtube.com/embed/KkjbiwbjUFY" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    -->

    </div>
    <div class="container">
    <form action="" method="POST">
        {{ csrf_field() }}
        
        @if($user)
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endif

        <input type="text" name="test">
        <button type="submit">Wyślij</button>
    </form>

    </div>
</section>
@stop
