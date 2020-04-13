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

        <form action="" method="post" class="form-horizontal">
            @csrf

            <fieldset>
                <legend>1A) Wybierz istniejącą osobę</legend>

                <div class="form-group {{ $errors->has('id') ? 'has-error' : '' }}">
                    <label for="id" class="control-label col-sm-2">
                        Osoba
                    </label>
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
                    <label for="person_first_name" class="control-label col-sm-2">
                        Imię
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="person[first_name]" id="person_first_name" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.first_name') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('person.last_name') ? 'has-error' : '' }}">
                    <label for="person_last_name" class="control-label col-sm-2">
                        Nazwisko
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="person[last_name]" id="person_last_name" class="form-control" />

                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.last_name') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('person.gender') ? 'has-error' : '' }}">
                    <label for="person_gender" class="control-label col-sm-2">
                        Płeć
                    </label>
                    <div class="col-sm-6">
                        <select id="person_gender" name="person[gender]" class="form-control">
                            <option value="male">Mężczyzna</option>
                            <option value="female">Kobieta</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.gender') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('person.email') ? 'has-error' : '' }}">
                    <label for="person_email" class="control-label col-sm-2">
                        E-mail
                    </label>
                    <div class="col-sm-6">
                        <input type="email" name="person[email]" id="person_email" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('person.email') }}
                    </div>
                </div>

            </fieldset>

            <fieldset>
                <legend>2) Opcje członka</legend>
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    <label for="status" class="control-label col-sm-2">
                        Status
                    </label>
                    <div class="col-sm-6">
                        <select name="status" id="status" class="form-control">
                            @foreach(NZS\Core\HR\Member::getStatusesAsChoices() as $value => $text)
                                <option value="{{ $value }}">
                                    {{ $text }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('status') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="has_badge" /> Czy osoba otrzymała przypinkę
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_member" value="1"  /> Czy osoba jest członkiem
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('member_since') ? 'has-error' : '' }}">
                    <label for="member_since" class="control-label col-sm-2">
                        Członek od
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="member_since" id="member_since"
                            class="form-control datepicker"
                            />
                    </div>
                    <div class="col-sm-4">
                        {{ $errors->first('member_since') }}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('member_to') ? 'has-error' : '' }}">
                    <label for="member_to" class="control-label col-sm-2">
                        Członek do
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="member_to" id="member_to"
                            class="form-control datepicker"
                            />
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
        </form>

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
