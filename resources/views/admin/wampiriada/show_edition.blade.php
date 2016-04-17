@extends('layouts.admin')

@section('title')
    Wyniki Wampiriady
@stop

@section('content')
    <div class="page-header">
        <h1>Wyniki {{ $edition }}. edycji Wampiriady</h1>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Akcja</th>
                <td class="info">Ogółem</td>
                <td>A+</td>
                <td>A-</td>
                <td>B+</td>
                <td>B-</td>
                <td>AB+</td>
                <td>AB-</td>
                <td>0+</td>
                <td>0-</td>
                <td>Nieznane</td>
            </tr>
        </thead>
        <tbody>
            @forelse($actions as $action)
                <tr>
                    <th><a href="{{ url('admin/wampiriada/edit/' . $action->id) }}">{{ $action->short_description }}</a></th>
                    <td class="info"><strong>{{ $action->data->getOverall() }}</strong></td>
                    <td>{{ $action->data->a_plus }}</td>
                    <td>{{ $action->data->a_minus }}</td>
                    <td>{{ $action->data->b_plus }}</td>
                    <td>{{ $action->data->b_minus }}</td>
                    <td>{{ $action->data->ab_plus }}</td>
                    <td>{{ $action->data->ab_minus }}</td>
                    <td>{{ $action->data->zero_plus }}</td>
                    <td>{{ $action->data->zero_minus }}</td>
                    <td>{{ $action->data->unknown }}</td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="11">
                    Aby dodać nowy wynik, wybierz jedną z akcji poniżej.
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="active">
                <th>Razem</th>
                <td class="info"><strong>{{ $summary->getOverall() }}</strong></td>
                <td>{{ $summary->getAPlus() }}</td>
                <td>{{ $summary->getAMinus() }}</td>
                <td>{{ $summary->getBPlus() }}</td>
                <td>{{ $summary->getBMinus() }}</td>
                <td>{{ $summary->getABPlus() }}</td>
                <td>{{ $summary->getABMinus() }}</td>
                <td>{{ $summary->getZeroPlus() }}</td>
                <td>{{ $summary->getZeroMinus() }}</td>
                <td>{{ $summary->getUnknown() }}</td>
            </tr>
        </tfoot>
    </table>
    
    @if(count($choices) > 0)
        <h2>Dodaj nowe wyniki</h2>
        <div class="row">
        {{ Form::open(['url' => 'admin/wampiriada/results', 'class' => 'col-md-4']) }}
            <div class="form-group">
                {{ Form::label('id', 'Wybierz akcję') }}
                {{ Form::select('id', $choices, null, ['class' => 'form-control']) }}
            </div>

            {{ Form::submit('Dodaj', ['class' => 'btn btn-default']) }}
        {{ Form::close() }}
        </div>
    @endif
@stop
