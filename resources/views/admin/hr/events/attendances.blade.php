@extends('layouts.admin')

@section('title')
    {{ $event->name }}
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/hr/events/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj wydarzenie</a>
            </div>
        </div>
        <h2>{{ $event->name }}</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Imię i nazwisko</th>
                <td>Data wydarzenia</td>
                <td>Czy publiczne</td>
                <td>Opis</td>
                <td>Akcje</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($attendance_aggregator->getMemberAttendees() as $user)
                <tr>
                    <th>{{ $user->getFullName() }}</th>
                    <td>{{ $user->pivot->additional_notes }}</td>
                    <td>{{ $user->pivot->role }}</td>
                    <td>{{ $user->pivot->attended_since }}</td>
                    <td>{{ $user->pivot->attended_to }}</td>
                    <td>
                        <a class="btn btn-default btn-sm" href="{{ url('admin/hr/events/' . $user->pivot->id . '/edit' )}}">
                            <i class="fa fa-edit"></i> Edytuj</i>
                        </a>
                    </td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="5">
                    Aby dodać nowe wydarzenie, naciśnij przycisk <strong>Dodaj wydarzenie</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
