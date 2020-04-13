@extends('layouts.admin')

@section('title')
    @if($prize->id)
        {{ $prize->name }} &mdash; edycja
    @else
        Dodaj nowy typ nagrody
    @endif
@stop

@section('content')
    <div class="page-header">
        <h1>
            @if($prize->id)
                {{ $prize->name }} &mdash; edycja
            @else
                Dodaj nowy typ nagrody
            @endif
        </h1>
    </div>

    <div class="container">

        <form action="" method="post" class="form-horizontal">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="control-label col-sm-2">
                    Nazwa wewnętrzna
                </label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name"
                        value="{{ $prize->name }}"
                        class="form-control" />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('name') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description" class="control-label col-sm-2">
                    Opis (dla otrzymującego)
                </label>
                <div class="col-sm-6">
                    <textarea id="description" name="description" class="form-control">{{ $prize->name }}</textarea>
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('description') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="active" value="1"
                                @if(($prize->id && $prize->active) || !$prize->id)
                                    checked
                                @endif
                                /> Nagroda dostępna
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
