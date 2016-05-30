@extends('layouts.admin')

@section('title')
    Lista e-maili w domenie @nzs.lodz.pl
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/email/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj</a>
            </div>
        </div>
        <h2>Lista e-maili @nzs.lodz.pl</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Adres</th>
                <td>Przekierowanie</td>
                <td>Aktywne</td>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $account)
                <tr @if(!$account->active) class="text-disabled" @endif>
                    <th>{{ $account->address }} </th>
                    <td>{{ $account->goto }}</td>
                    <td>{{ $account->active }}</td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="3">
                    Nie ma żadnych e-maili w domenie nzs.lodz.pl.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
@stop
