@extends('layouts.admin')

@section('title')

    Określ płeć dla {{ $person->getFullName() }}
@stop

@section('content')
    <div class="page-header">
        <h1>
            Określ płeć dla {{ $person->getFullName() }}
        </h1>
    </div>

    <div class="container">

        {{ Form::open(array('class' => 'form-horizontal')) }}

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button class="btn btn-default btn-large" name="gender" value="male"><i class="fa fa-male"></i> Mężczyzna</button>
                    <button class="btn btn-default btn-large" name="gender" value="female"><i class="fa fa-female"></i> Kobieta</button>
                    <button class="btn btn-default" name="gender" value="skip">Pomiń</button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::select('_next', storyboard()->choices('_next'), storyboard()->value('_next'), ['class' => 'form-control']) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>

@stop
