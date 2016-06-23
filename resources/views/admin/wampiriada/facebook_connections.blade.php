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

            @forelse($connections as $connection)
                <tr id="user-{{ $connection->getUser()->id }}">
                    <th>
                        <a data-card="{{ $connection->getUser()->id }}" href="{{ url('admin/activity/profile/'. $connection->getUser()->id) }}">{{ $connection->getUser()->getFullName() }}</a>

                        @if($connection->getUser()->facebook_user_id)
                            <small><a href="https://facebook.com/{{ $connection->getUser()->facebook_user_id }}">facebook</a></small>
                        @endif

                    </th>
                    <td class="info"><strong>{{ $connection->getScore() }}</strong></td>
                    <td>
                    <small>
                        @foreach($connection->getFriendCheckinsPresentOnActionIncludingMe() as $friend_checkin)
                            {{ $friend_checkin->friend_checkin->created_at->format('H:i') }}
                            @if(!$connection->isSelf($friend_checkin))
                            <a href="#user-{{ $friend_checkin->friend_checkin->user_id }}">
                            @endif
                                <em>{{ $friend_checkin->friend_checkin->user->getFullName() }}</em>
                            @if(!$connection->isSelf($friend_checkin))
                            </a>
                            @endif

                            <br>
                        @endforeach
                    </small>
                    </td>
                    <td>
                    <small>
                        @foreach($connection->getFriendCheckinsNotPresentOnAction() as $friend_checkin)
                            <a href="#user-{{ $friend_checkin->friend_checkin->user_id }}"><em>{{ $friend_checkin->friend_checkin->user->getFullName() }}</em></a><br>
                        @endforeach
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
