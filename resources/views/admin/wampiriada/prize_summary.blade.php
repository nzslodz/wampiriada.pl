@extends('layouts.admin')

@section('title')
    Lista nagród
@stop

@section('content')
    <div class="page-header">
        <h2>Nagrody {{ $edition->number }}. edycji Wampiriady</h2>
    </div>
    <div class="row input-second">
        <div class="col-md-4">
            <div class="card">
            <strong>{{ $prizes->count() }}</strong>
            osób ma przyznane nagrody
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
            <strong>{{ $summary->countClaimedPrizes() }}</strong>
            je odebrało
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
            <strong>{{ $summary->countUnclaimedPrizes() }}</strong>
            nieodebranych
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nagroda</th>
                <td>Odebranych</td>
                <td>Zarezerwowanych</td>
                <td>Razem</td>
            </tr>
        </thead>
        <tbody>
            @forelse($summary->getItemsInSet() as $prize_type)
                <tr>
                    <th>{{ $prize_type->name }}</th>
                    <td>{{ $prize_type->claimed }}</td>
                    <td>{{ $prize_type->unclaimed }}</td>
                    <td>{{ $prize_type->count }}</td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="4">
                    Brak nagród.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Lista osób z nagrodami</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>L.p.</th>
                <th>Osoba</th>
                <td>Co dostała</td>
                <td>Po jakim czasie odebrano</td>
            </tr>
        </thead>
        <tbody>
            @forelse($prizes as $group)
                <tr class="info">
                    <th colspan="4" class="text-center">
                        <a href="{{ url('admin/wampiriada/edit/' . $group[0]->checkin->action_day_id) }}">
                        {{ $group[0]->checkin->actionDay->created_at->format('d/m') }} {{ $group[0]->checkin->actionDay->place->name }}
                        </a>
                    </th>
                </tr>

                @foreach($group as $prize)
                    <tr class="">
                        <th>{{ $iterator += 1 }}</th>
                        <th>
                            <a data-card="{{ $prize->checkin->user_id }}" href="{{ url('admin/activity/profile/' . $prize->checkin->user_id )}}">
                                @if($prize->checkin->user->getFullName() != ' ')
                                    {{ $prize->checkin->user->getFullName() }}
                                @else
                                    {{ $prize->checkin->name }}
                                @endif
                            </a>

                            @if($prize->checkin->user->facebook_user_id)
                                <small><a href="https://facebook.com/{{ $prize->checkin->user->facebook_user_id }}">facebook</a></small>
                            @endif
                        </th>
                        <td>
                            @foreach($prize->items as $type)
                                {{ $type->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @if($prize->claimed_at)
                                {{ $prize->getTimeDiffUntilClaimed() }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @empty
            <tr class="no-results">
                <td colspan="4">
                    Brak nagród.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

@stop
