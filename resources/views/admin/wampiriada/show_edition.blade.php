@extends('layouts.admin')

@section('title')
    Wyniki Wampiriady
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/wampiriada/settings/' . $edition) }}" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span> Ustawienia</a>
                <a href="{{ url('admin/wampiriada/connections/' . $edition) }}" class="btn btn-default"><i class="fa fa-facebook"></i> Konkurs FB</a>
                <a href="{{ url('admin/wampiriada/prize/summary/' . $edition) }}" class="btn btn-default"><i class="fa fa-star-o"></i> Nagrody</a>
            </div>
        </div>
        <h2>Wyniki {{ $edition }}. edycji Wampiriady</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Akcja</th>
                <td class="info">Ogółem</td>
                <td>Nowych</td>
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
                    <td>{{ $action->checkins()->whereFirstTime(true)->count() }}
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
                <td colspan="12">
                    Aby dodać nowy wynik, wybierz jedną z akcji poniżej.
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="active">
                <th>Razem</th>
                <td class="info"><strong>{{ $summary->sumData('overall') }}</strong></td>
                <td>{{ $edition_object->checkins()->whereFirstTime(true)->count() }}</td>
                <td>{{ $summary->sumData('a_plus') }}</td>
                <td>{{ $summary->sumData('a_minus') }}</td>
                <td>{{ $summary->sumData('b_plus') }}</td>
                <td>{{ $summary->sumData('b_minus') }}</td>
                <td>{{ $summary->sumData('ab_plus') }}</td>
                <td>{{ $summary->sumData('ab_minus') }}</td>
                <td>{{ $summary->sumData('zero_plus') }}</td>
                <td>{{ $summary->sumData('zero_minus') }}</td>
                <td>{{ $summary->sumData('unknown') }}</td>
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
