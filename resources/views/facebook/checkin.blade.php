@extends('layouts.master')

@section('content')
    <div class="container">
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
            <div class="form-group">
                {{ Form::label('name', 'Imię i nazwisko', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('name', $profile->current_name ? $profile->current_name : Auth::user()->getFullName(), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('size', 'Rozmiar koszulki', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::select('size', $sizes, $profile->default_size_id, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('blood_type', 'Rodzaj krwi', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::select('blood_type', $blood_types, $profile->blood_type_id, ['class' => 'form-control']) }}
                </div>
            </div>
            @if($first_time)
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('first_time', '1', false, ['class' => '']) }} Oddaję pierwszy raz
                            </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>

@stop
