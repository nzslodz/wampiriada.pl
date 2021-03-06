@extends('layouts.admin')

@section('title')

        Dodaj nowego uczestnika
@stop

@section('content')
    <div class="page-header">
        <h1>
                Dodaj NZSiaka
        </h1>
    </div>

    <div class="container">

        {{ Form::open(array('class' => 'form-horizontal')) }}


            <fieldset>
                <legend>1A) Wybierz istniejącą osobę</legend>

                <div class="form-group {{ $errors->has('id') ? 'has-error' : '' }}">
                    {{ Form::label('id', 'Osoba', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">

                        <select name="id" class="selector form-control"></select>
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('id') }}
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>1B) Albo dodaj nową osobę</legend>

                <div class="form-group {{ $errors->has('person.first_name') ? 'has-error' : '' }}">
                    {{ Form::label('person[first_name]', 'Imię', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::text('person[first_name]', '', ['class' => 'form-control']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.first_name') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('person.last_name') ? 'has-error' : '' }}">
                    {{ Form::label('person[last_name]', 'Nazwisko', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::text('person[last_name]', '', ['class' => 'form-control']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.last_name') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('person.gender') ? 'has-error' : '' }}">
                    {{ Form::label('person[gender]', 'Płeć', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::select('person[gender]', ['male' => 'Mężczyzna', 'female' => 'Kobieta'], '', ['class' => 'form-control']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.gender') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('person.email') ? 'has-error' : '' }}">
                    {{ Form::label('person[email]', 'E-mail', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::text('person[email]', '', ['class' => 'form-control']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.email') }}
                    </div>
                </div>

            </fieldset>

            <fieldset>
                <legend>2) Opcje członka</legend>
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    {{ Form::label('status', 'Status', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::select('status', NZS\Core\HR\Member::getStatusesAsChoices(), null, ['class' => 'form-control']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('status') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('has_badge', '1', false, ['class' => '']) }} Czy osoba otrzymała przypinkę
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('is_member', '1', false, ['class' => '']) }} Czy osoba jest członkiem
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('member_since') ? 'has-error' : '' }}">
                    {{ Form::label('member_since', 'Członek od', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::text('member_since', '', ['class' => 'form-control datepicker']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('member_since') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('member_to') ? 'has-error' : '' }}">
                    {{ Form::label('member_since', 'Członek do', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-6">
                        {{ Form::text('member_to', '', ['class' => 'form-control datepicker']) }}
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('member_to') }}
                    </div>
                </div>
            </fieldset>

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@stop

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
      <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
       <script type="text/javascript">
            $(function() {

                $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

                $('.selector').select2({
                    placeholder: "Wpisz e-mail lub imię/nazwisko...",
                    minimumInputLength: 2,
                    ajax: {
                        url: '{{ url('admin/hr/autocomplete') }}',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: $.trim(params.term.toLowerCase()),
                                page: params.page,
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
               });
           })
       </script>
@stop
