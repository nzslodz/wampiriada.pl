@extends('layouts.admin')

@section('title')
    {{ $action->getShortDescriptionAttribute() }} &mdash; edycja
@stop

@section('content')
    <div class="page-header">
        <h1>{{ $action->getShortDescriptionAttribute() }} &mdash; edycja</h1>
    </div>

    {{ Form::open(array('url' => 'admin/wampiriada/edit/' . $action->id, 'class' => 'form-horizontal')) }}
        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('a_plus', 'A+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('a_plus', $data->a_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('a_minus', 'A-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('a_minus', $data->a_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('b_plus', 'B+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('b_plus', $data->b_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('b_minus', 'B-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('b_minus', $data->b_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('unknown', 'Nieznana', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('unknown', $data->unknown, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('ab_plus', 'AB+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('ab_plus', $data->ab_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('ab_minus', 'AB-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('ab_minus', $data->ab_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('zero_plus', '0+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('zero_plus', $data->zero_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('zero_minus', '0-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('zero_minus', $data->zero_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('overall', 'Razem', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('overall', $data->getOverall(), ['class' => 'form-control', 'data-calculate' => 'overall', 'readonly' => 'true']) }}
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
            </div>
            </div>
            </div>
            </div>
        </div>
    {{ Form::close() }}
    
@stop
