@extends('layouts.master')




@section('content')
    {{ Auth::user()->getFacebookProfileImagePath() }}
    
    <div class="page-header">
        <h1> Lista krwiodawców</h1>
        <p>Wpisz się aby dostać koszulkę</p>
    </div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    {{ Form::open(array('url' => '/facebook/checkin', 'class' => 'form-horizontal')) }}
        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('name', 'Imię i nazwisko', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::text('name', $profile->current_name ? $profile->current_name : Auth::user()->getFullName(), ['class' => 'form-control']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('size', 'Rozmiar koszulki', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::select('size', $sizes, $profile->default_size_id, ['class' => 'form-control']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('blood_type', 'Rodzaj krwi', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::select('blood_type', $blood_types, $profile->blood_type_id, ['class' => 'form-control']) }}
            </div>
            </div>
            
            @if($first_time)
            <div class="form-group">
            {{ Form::label('first_time', 'Oddaję pierwszy raz', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::checkbox('first_time', '1', false, ['class' => 'form-control']) }}
            </div>
            </div>
            @endif
        </div>
        
        <div class="row">
        <div class="col-md-6">
            <div class="row">
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
