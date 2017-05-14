@extends('layouts.admin')

@section('title')
    Lista NZSiaków
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/hr/members/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj nowego NZSiaka</a>
            </div>
        </div>
        <h2>Lista NZSiaków</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Imię i nazwisko</th>
                <td>Email</td>
                <td>Status</td>
                <td>Członek od</td>
                <td>Akcje</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($members as $member)
                <tr>
                    <th><a href="{{ url('admin/hr/members/' . $member->id ) }}">{{ $member->user->getFullName() }}</a></th>
                    <td>{{ $member->present()->email }}</td>
                    <td>
                        {{ $member->present()->hasBadgeIcon() }}
                        {{ $member->present()->isMemberIcon() }}
                        {{ $member->getStatus() }}

                    </td>
                    <td>
                        {{ $member->present()->memberSince() }}
                    </td>
                    <td>
                        <a class="btn btn-default btn-sm" href="{{ url('admin/hr/members/' . $member->id . '/edit' )}}">
                            <i class="fa fa-edit"></i> Edytuj</i>
                        </a>
                    </td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="5">
                    Aby dodać nową osobę, naciśnij przycisk <strong>Dodaj nowego NZSiaka</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
