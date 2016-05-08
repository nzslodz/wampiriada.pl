@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h2>Lista odbioru koszulek</h2>
            <p><a href="{{ $login_url }}">Zaloguj się z Facebookiem, aby kontynuować</a></p>
            <a href="#alternative-form" data-toggle="collapse">Nie posiadam Facebooka</a>
        </div>
    </div>
</div>



<div class="container @if($errors->isEmpty()) collapse @endif" id="alternative-form">
	<div class="well well-dark">
			<h3>Podaj swój e-mail:</h3>
 {{ Form::open(array('class' => 'form-horizontal')) }}
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Adres e-mail', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::email('email', '', ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('email') }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Wyślij', ['class' => 'btn btn-default']) }}
                </div>
            </div>
 {{ Form::close() }}
 </div>
</div>

@stop
