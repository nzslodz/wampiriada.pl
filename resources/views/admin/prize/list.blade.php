@extends('layouts.admin')

@section('title')
    Lista typów nagród
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/prize/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj nowy typ nagrody</a>
            </div>
        </div>
        <h2>Lista typów nagród</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nazwa wewnętrzna</th>
                <td>Opis (dla otrzymujących)</td>
                <td>Dostępne</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($prizes as $prize)
                <tr>
                    <th><a href="{{ url('admin/prize/edit/' . $prize->id) }}">{{ $prize->name }}</a></th>
                    <td>{{ $prize->description }}</td>
                    <td>
                        <button class="btn btn-default btn-sm" data-toggle="checkbox" data-url="{{ url('admin/prize/toggle/' . $prize->id) }}">
                            <span class="text-success {{ $prize->active ? '': 'hidden' }}" data-active><i class="fa fa-check"></i> Dostępne</span>
                            <span class="text-danger {{ $prize->active ? 'hidden': '' }}" data-inactive><i class="fa fa-times"></i> Niedostępne</span>
                        </button>
                    </td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="3">
                    Aby dodać nowy typ nagrody, naciśnij przycisk <strong>Dodaj nowy typ nagrody</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
