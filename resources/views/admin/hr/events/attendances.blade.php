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

    <form action="" method="post" class="form-horizontal">
        @csrf

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td></td>
                <th>Imię i nazwisko</th>
                <td>Notatka</td>
                <td>Rola</td>
                <td>Od</td>
                <td>Do</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($attendance_aggregator->getActiveMembers() as $proxy)
                <tr>
                    <td><input type="checkbox" value="{{ $proxy->id }}" name="active_members[]" @if(in_array($proxy->id, old('active_members', $attendance_aggregator->getAttendedIds()))) checked @endif ></td>
                    <th><a data-card="{{ $proxy->id }}" href="{{ url('admin/activity/profile/' . $proxy->id )}}">
                    {{ $proxy->getFullName() }}</td></th>

                    <td><input type="text" name="attendees[{{ $proxy->id }}][additional_notes]" value="{{ old("attendees.$proxy->id.additional_notes", $proxy->attendance->additional_notes) }}"></td>
                    <td><input type="text" name="attendees[{{ $proxy->id }}][role]" value="{{ old("attendees.$proxy->id.role", $proxy->attendance->role) }}"></td>
                    <td><input type="text" name="attendees[{{ $proxy->id }}][attended_since]" value="{{ old("attendees.$proxy->id.attended_since", $proxy->attendance->attended_since) }}"></td>
                    <td><input type="text" name="attendees[{{ $proxy->id }}][attended_to]" value="{{ old("attendees.$proxy->id.attended_to", $proxy->attendance->attended_to) }}"></td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="6">
                    Aby dodać nowe wydarzenie, naciśnij przycisk <strong>Dodaj wydarzenie</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>


    </table>
    <div class="form-group">
        <div class="col-xs-12 text-right">
            <button class="btn btn-primary" name="_save" type="submit" value="1">Zapisz</button>
        </div>
    </div>

    </form>

    XXX -> OSOBY SPOZA MEMBERÓW
@stop
