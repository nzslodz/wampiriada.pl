@extends('layouts.admin')

@section('title')
    {{ $action->getShortDescriptionAttribute() }} &mdash; edycja
@stop

@section('content')
    <div class="page-header">
        <h1>{{ $action->getShortDescriptionAttribute() }} &mdash; edycja</h1>
    </div>

    <div class="row input-second">
        <div class="col-md-3">
            <div class="card">
            <strong>{{ $data->getOverall() }}</strong>
            oddało krew
            </div>
        </div>

        @if($checkin_count > 0)
        <div class="col-md-3">
            <div class="card">
            <strong>{{ $checkin_count }}</strong>
            wpisanych na listę
            </div>
        </div>
        <div class="col-md-3">
            <div class="card @if($first_time_checkin_count_percentage == 0) card-disabled @endif">
            <strong>{{ $first_time_checkin_count_percentage }}%</strong>
            osób biorących udział pierwszy raz
            </div>
        </div>
        <div class="col-md-3">
            
            <div class="card @if($missing_count == 0) card-disabled @endif">
            <strong>{{ $missing_count }}</strong>
            osób brakujących na liście
            </div>
        </div>
        @endif
    </div>

    {{ Form::open(array('url' => 'admin/wampiriada/edit/' . $action->id, 'class' => 'form-horizontal')) }}
        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('a_plus', 'A+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('a_plus', $data->a_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('a_minus', 'A-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('a_minus', $data->a_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('b_plus', 'B+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('b_plus', $data->b_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('b_minus', 'B-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('b_minus', $data->b_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('unknown', 'Nieznana', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('unknown', $data->unknown, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('ab_plus', 'AB+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('ab_plus', $data->ab_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('ab_minus', 'AB-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('ab_minus', $data->ab_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('zero_plus', '0+', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('zero_plus', $data->zero_plus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            <div class="form-group">
            {{ Form::label('zero_minus', '0-', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('zero_minus', $data->zero_minus, ['class' => 'form-control', 'data-calculate' => 'source']) }}
            </div>
            </div>
            </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            {{ Form::label('overall', 'Razem', ['class' => 'control-label col-sm-2']) }}
            <div class="col-sm-10">
            {{ Form::number('overall', $data->getOverall(), ['class' => 'form-control', 'data-calculate' => 'overall', 'readonly' => 'true']) }}
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
            </div>
            </div>
            </div>
            </div>
        </div>
    {{ Form::close() }}
   
    <h3>Osoby, które oddały krew</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Lp.</th>
                <th>Imię i nazwisko</th>
                <td>E-mail</td>
                <td>Godzina wpisu</td>
                <td>Rozmiar koszulki</td>
                <td>Grupa krwi</td>
                <td>Pierwszy raz</td>
            </tr>
        </thead>
        <tbody>
            @forelse($checkins as $key => $checkin)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <th>

                        @if($checkin->user->getFullName() != ' ')
                            {{ $checkin->user->getFullName() }}
                        @else
                            {{ $checkin->name }}
                        @endif

                        @if($checkin->user->facebook_user_id)
                            <small><a href="https://facebook.com/{{ $checkin->user->facebook_user_id }}">facebook</a></small>
                        @endif

                    </th>
                    <td>{{ $checkin->user->email }}</td>
                    <td>{{ $checkin->created_at->format('H:i:s') }}</td>
                    @if($checkin->size)
                    <td>{{ $checkin->size->name }}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $checkin->blood_type->name }}</td>
                    <td>
                        @if($checkin->first_time)
                        <span class="glyphicon glyphicon-check"></span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="no-results">
                    <td colspan="7">
                        Do tej akcji nikt jeszcze się nie wpisał.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
@stop
