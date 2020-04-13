@extends('layouts.admin')

@section('title')
    Dodaj nowy adres e-mailowy
@stop

@section('content')
    <div class="page-header">
        <h1>Dodaj nowy adres e-mailowy</h1>
    </div>

    <form action="/admin/email/create" method="post" class="form-horizontal">
        @csrf
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email" class="control-label col-sm-2">
                    Adres w domenie nzs.lodz.pl
                </label>

                <div class="col-sm-6">
                    <input type="email" name="email" id="email" class="form-control" placeholder="jan.kowalski@nzs.lodz.pl" />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('email') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password" class="control-label col-sm-2">
                    Hasło (8-32)
                </label>
                <div class="col-sm-6">
                    <input type="text" name="password" id="password" class="form-control" />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('password') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('alias_email') ? 'has-error' : '' }}">
                <label for="alias_email" class="control-label col-sm-2">
                    Przekierowanie
                </label>
                <div class="col-sm-6">
                    <input type="email" id="alias_email" name="alias_email" class="form-control" placeholder="jkowalski@gmail.com" />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('alias_email') }}
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        Zapisz
                    </button>
                </div>
            </div>
        </form>

@stop
