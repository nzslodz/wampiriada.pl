@extends('layouts.admin')

@section('title')

        @if($event->id)
            Edytuj {{ $event->name }}
        @else
            Dodaj nowe wydarzenie
        @endif
@stop

@section('content')
    <div class="page-header">
        <h1>
            @if($event->id)
                Edytuj {{ $event->name }}
            @else
                Dodaj nowe wydarzenie
            @endif
        </h1>
    </div>

    <div class="container">

        {{ Form::open(array('class' => 'form-horizontal')) }}

            <div class="form-group {{ $errors->has('happened_at') ? 'has-error' : '' }}">
                {{ Form::label('happened_at', 'Data wydarzenia', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('happened_at', $event->happened_at ? $event->happened_at->format('Y-m-d') : null, ['class' => 'form-control datepicker']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('happened_at') }}
                </div>
            </div>

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Nazwa', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('name', $event->name, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('name') }}
                </div>
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                {{ Form::label('description', 'Krótki opis', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::textarea('description', $event->description, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('description') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('is_public', '1', $event->is_public, ['class' => '']) }} Czy wydarzenie jest publiczne
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    @foreach(storyboard()->choices('_save') as $value => $transition)
                        <button class="btn btn-default" name="_save" type="submit" value="{{ $value }}">{{ $transition }}</button>
                    @endforeach
                </div>
            </div>
        {{ Form::close() }}

    </div>

@stop

@section('extrahead')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@stop

@section('script')
      <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
       <script type="text/javascript">
            $(function() {
                $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
            })
       </script>
@stop
