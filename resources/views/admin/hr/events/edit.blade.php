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

        <form action="" method="post" class="form-horizontal">
            @csrf

            <div class="form-group {{ $errors->has('happened_at') ? 'has-error' : '' }}">
                <label for="happened_at" class="control-label col-sm-2">
                    Data wydarzenia
                </label>
                <div class="col-sm-6">
                    <input type="text" id="happened_at" name="happened_at"
                        value="{{ $event->happened_at ? $event->happened_at->format('Y-m-d') : null }}"
                        class="form-control datepicker" />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('happened_at') }}
                </div>
            </div>

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="control-label col-sm-2">
                    Nazwa
                </label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name"
                        value="{{ $event->name }}"
                        class="form-control" />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('name') }}
                </div>
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description" class="control-label col-sm-2">
                    Krótki opis
                </label>
                <div class="col-sm-6">
                    <textarea id="description" name="description" class="form-control">{{ $event->description }}</textarea>
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('description') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_public" value="1"
                                @if($event->is_public)
                                    checked
                                @endif
                            /> Czy wydarzenie jest publiczne
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
        </form>

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
