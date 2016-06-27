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
            nagród
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
            <strong>{{ $summary->countClaimedPrizes() }}</strong>
            odebranych nagród
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
                <td>Zarezerwowanych</td>
                <td>Odebranych</td>
                <td>Razem</td>
            </tr>
        </thead>
        <tbody>
            @forelse($summary->getItemsInSet() as $prize_type)
                <tr>
                    <th>{{ $prize_type->name }}</th>
                    <td>{{ $prize_type->unclaimed }}</td>
                    <td>{{ $prize_type->claimed }}</td>
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

@stop
