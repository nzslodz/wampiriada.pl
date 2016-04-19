@extends('layouts.admin')

@section('title')
    Lista edycji Wampiriady
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/wampiriada/new') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj nową edycję</a>
            </div>
        </div>
        <h2>Lista akcji Wampiriady</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Edycja</th>
                <td class="info">Ogółem</td>
                <td>Termin</td>
            </tr>
        </thead>
        <tbody>
            @forelse($editions as $edition)
                <tr>
                    <th><a href="{{ url('admin/wampiriada/show/' . $edition->number) }}">{{ $edition->name }}</a></th>
                    <td class="info"><strong>{{ $edition->getRepository()->safeGetOverall() }}</strong></td>
                    <td>{{ $edition->getStartDate()->format('Y-m') }} &mdash; {{ $edition->getEndDate()->format('Y-m') }}</td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="3">
                    Aby dodać nową edycję, naciśnij przycisk <strong>Dodaj nową edycję</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
