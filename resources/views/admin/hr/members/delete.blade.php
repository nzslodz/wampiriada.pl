@extends('layouts.admin')

@section('title')

        Usuń {{ $member->present()->fullName() }}
@stop

@section('content')
    <div class="page-header">
        <h1>
                Usuń {{ $member->present()->fullName() }}
        </h1>
    </div>

    <div class="container">

        <form action="" method="post" class="form-horizontal">
            @csrf
            <h2>Czy na pewno usunąć?</h2>

            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-danger" name="_delete" type="submit" value="1">Usuń</button>
                    <a href="{{ route('admin-hr-members-show', $member->id)}}" class="btn btn-default" name="_delete" type="submit" value="1">Powróć do poprzedniej strony</a>
                </div>
            </div>

        </form>

    </div>

@stop
