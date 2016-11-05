@extends('layouts.admin')

@section('title')
    Edycja {{ $edition_number }}. &mdash; ustawienia
@stop

@section('content')
    <div class="page-header">
        <h1>Edycja {{ $edition_number }}. &mdash; ustawienia</h1>
    </div>

    {{ Form::open(array('url' => 'admin/wampiriada/settings/' . $edition_number, 'class' => 'form-horizontal')) }}
        <div class="row">
            <div class="col-md-9">
                <h3>Linki do stron</h3>

                <div class="form-group">
                    {{ Form::label('redirect_event', 'Event na Facebooku', ['class' => 'control-label col-sm-4']) }}
                    <div class="col-sm-8">
                    {{ Form::text('redirect_event', $redirect_event->url, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('redirect_koszulka', 'Zdjęcie koszulek (fb)', ['class' => 'control-label col-sm-4']) }}
                    <div class="col-sm-8">
                    {{ Form::text('redirect_koszulka', $redirect_koszulka->url, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('redirect_plakat', 'Zdjęcie plakatu (fb)', ['class' => 'control-label col-sm-4']) }}
                    <div class="col-sm-8">
                    {{ Form::text('redirect_plakat', $redirect_plakat->url, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Koszulki</h3>

                @foreach($checkboxes as $checkbox)
                <div>
                    {{ Form::checkbox("sizes[]", $checkbox->id, $checkbox->active, ['id' => "size_$checkbox->id"]) }}
                    {{ Form::label("size_$checkbox->id", $checkbox->name) }}
                </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="container-xs-12">
                <edition-list></edition-list>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                 {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
            </div>
        </div>
    {{ Form::close() }}

@stop

@section('data')
    <script type="text/javascript">
        actionList = {!! $actions->toJson() !!}
    </script>
@stop
