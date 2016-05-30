@extends('layouts.admin')

@section('title')
    Dodaj nowy adres e-mailowy
@stop

@section('content')
    <div class="page-header">
        <h1>Dodaj nowy adres e-mailowy</h1>
    </div>

    {{ Form::open(array('url' => '/admin/email/create', 'class' => 'form-horizontal')) }}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::label('email', 'Adres w domenie nzs.lodz.pl', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'jan.kowalski@nzs.lodz.pl']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('email') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::label('password', 'Hasło (8-32)', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('password', null, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('password') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('alias_email') ? 'has-error' : '' }}">
                {{ Form::label('alias_email', 'Przekierowanie', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::email('alias_email', null, ['class' => 'form-control', 'placeholder' => 'jkowalski@gmail.com']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('alias_email') }}
                </div>
            </div>

           
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
                </div>
            </div>
        {{ Form::close() }}
    
@stop
