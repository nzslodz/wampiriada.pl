@extends('layouts.admin')

@section('title')
    @if($prize->id)
        {{ $prize->name }} &mdash; edycja
    @else
        Dodaj nowy typ nagrody
    @endif
@stop

@section('content')
    <div class="page-header">
        <h1>
            @if($prize->id)
                {{ $prize->name }} &mdash; edycja
            @else
                Dodaj nowy typ nagrody
            @endif
        </h1>
    </div>

    <div class="container">

        {{ Form::open(array('class' => 'form-horizontal')) }}
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Nazwa wewnętrzna', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('name', $prize->name, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('name') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                {{ Form::label('description', 'Opis (dla otrzymującego)', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::textarea('description', $prize->name, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('description') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('active', '1', $prize->id ? $prize->active : true, ['class' => '']) }} Nagroda dostępna
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>

@stop
