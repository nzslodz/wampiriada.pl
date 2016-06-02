@extends('layouts.admin')

@section('title')
    Konkurs facebookowy
@stop

@section('content')
    <div class="page-header">
        <h2>Konkurs facebookowy &mdash; wyniki</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Osoba</th>
                <td class="info">Punkty</td>
                <td>Na akcji</td>
                <td>Poza akcją z</td>
            </tr>
        </thead>
        <tbody>

            @forelse($users as $user)
                <tr id="user-{{ $user->id }}">
                    <th>
                        {{ $user->getFullName() }}

                        @if($user->facebook_user_id)
                            <small><a href="https://facebook.com/{{ $user->facebook_user_id }}">facebook</a></small>
                        @endif

                    </th>
                    <td class="info"><strong>{{ $user->score }}</strong></td>
                    <td>
                    <small>
                    @if($user->facebook_connections_present_on_action)
                        @foreach($user->facebook_connections_present_on_action as $connection)
                            {{ $users[$connection]->created_at->format('H:i') }}
                            @if($users[$connection]->id != $user->id)
                            <a href="#user-{{ $connection }}">
                            @endif
                                <em>{{ $users[$connection]->getFullName() }}</em>
                            @if($users[$connection]->id != $user->id)
                            </a>
                            @endif

                            <br>
                        @endforeach
                    @endif
                    </small>
                    </td>
                    <td>
                    <small>
                    @if($user->facebook_connections_not_present_on_action)
                        @foreach($user->facebook_connections_not_present_on_action as $connection)
                            <a href="#user-{{ $connection }}"><em>{{ $users[$connection]->getFullName() }}</em></a><br>
                        @endforeach
                    @endif
                    </small>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="4">
                    Brak osób biorących udział w konkursie.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
