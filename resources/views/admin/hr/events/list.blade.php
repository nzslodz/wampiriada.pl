@extends('layouts.admin')

@section('title')
    Lista wydarzeń
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/hr/events/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj wydarzenie</a>
            </div>
        </div>
        <h2>Lista wydarzeń</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nazwa</th>
                <td>Data wydarzenia</td>
                <td>Czy publiczne</td>
                <td>Opis</td>
                <td>Akcje</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($events as $event)
                <tr>
                    <th><a href="{{ url('admin/hr/events/' . $event->id ) }}">{{ $event->name }}</a></th>
                    <td>{{ $event->happened_at->format('Y-m-d') }}</td>
                    <td>
                        {{ $event->present()->isPublicIcon() }}
                    </td>
                    <td>
                        {{ $event->description }}
                    </td>
                    <td>
                        <a class="btn btn-default btn-sm" href="{{ url('admin/hr/events/' . $event->id . '/edit' )}}">
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
