@extends('layouts.admin')

@section('title')
    Wyniki Wampiriady
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/wampiriada/settings/' . $edition) }}" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span> Ustawienia</a>
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
                    <td class="info"><strong>{{ $action->data->overall }}</strong></td>
                    <td>{{ $action->data->first_time }}</td>
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
                <td>{{ $edition_object->data->first_time }}</td>
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

    <h2>Przypomnienia</h2>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>L.p.</td>
                <th>Osoba</th>
                <td>Dodano</td>
                <td>Flagi</td>
            </tr>
        </thead>
        <tbody>
            @forelse($reminder_actions as $action)
                @if($action->reminders()->count() > 0)
                    <tr class="info">
                        <th colspan="4" class="text-center">
                            {{ $action->short_description }}
                        </th>
                    </tr>
                    @foreach($action->reminders as $reminder)
                    <tr class="@if($reminder->hasCheckin()) success @elseif($reminder->hasAnyCheckin()) warning @elseif($action->inPast()) danger @endif">
                        <td>{{ $iterator += 1 }} / {{ $loop->iteration }}</td>
                        <th>
                            {{ $reminder->user->getFullName() }}
                        </th>
                        <td>
                            {{ $reminder->created_at }}
                        </td>
                        <td class="text-center">
                            @if($reminder->sent)
                                <i class="fa fa-envelope" title="Wiadomość e-mailowa wysłana"></i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endif
            @empty
                <tr class="no-results">
                    <td colspan="4">
                        Ta edycja nie posiada jeszcze żadnych przypomnień.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop
