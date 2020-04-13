@extends('layouts.admin')

@section('title')
    Edycja {{ $edition_number }}. &mdash; ustawienia
@stop

@section('content')
    <div class="page-header">
        <h1>Edycja {{ $edition_number }}. &mdash; ustawienia</h1>
    </div>

    <form action="/admin/wampiriada/settings/{{ $edition_number }}" method="post" class="form-horizontal">
        @csrf
        <section class="form-horizontal">
            <div class="row">
                <div class="col-md-9">
                    <h3>Linki do stron</h3>

                    <div class="form-group">
                        <label for="redirect_event" class="control-label col-sm-4">
                            Event na Facebooku
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="redirect_event" id="redirect_event"
                                value="{{ $redirect_event->url }}"
                                class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="redirect_koszulka" class="control-label col-sm-4">
                            Zdjęcie koszulek (fb)
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="redirect_koszulka" id="redirect_koszulka"
                                value="{{ $redirect_koszulka->url }}"
                                class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="redirect_plakat" class="control-label col-sm-4">
                            Zdjęcie plakatu (fb)
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="redirect_plakat" id="redirect_plakat"
                                value="{{ $redirect_plakat->url }}"
                                class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <h3>Koszulki</h3>

                    @foreach($checkboxes as $checkbox)
                    <div>
                        <label>
                            <input type="checkbox" name="sizes[]" value="{{ $checkbox->id }}"
                                @if($checkbox->active)
                                    checked
                                @endif
                                />
                            {{ $checkbox->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="container-xs-12">

                    <label>
                        <input type="checkbox" name="display_results" value="1"
                            @if($configuration->display_results)
                                checked
                            @endif
                            />
                        Pokaż wykres z wynikami edycji na stronie głównej
                    </label>
                </div>
                <div class="container-xs-12">
                    <label>
                        <input type="checkbox" name="display_actions" value="1"
                            @if($configuration->display_results)
                                checked
                            @endif
                            />
                        Pokaż listę akcji na stronie głównej (jeśli odznaczone, pokaże się komunikat informujacy o tym, że lista będzie dostępna już niebawem)
                    </label>
                </div>
                <div class="container-xs-12">
                    <label>
                        <input type="checkbox" name="display_faces" value="1"
                            @if($configuration->display_results)
                                checked
                            @endif
                            />
                        Pokaż grafikę 1000 twarzy Wampiriady na stronie głównej
                    </label>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="container-xs-12 col-md-12">
                <editionlist></editionlist>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 save-margin">
                 <button type="submit" class="btn btn-default">
                     Zapisz ustawienia
                 </button>
            </div>
        </div>
    </form>
@stop

@section('data')
    <script type="text/javascript">
        @if($actions)
        actionList = {!! $actions->toJson() !!}
        @else
        actionList = []
        @endif

        placeList = {!! $places->toJson() !!}
    </script>
@stop
