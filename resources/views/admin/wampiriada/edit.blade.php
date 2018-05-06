@extends('layouts.admin')

@section('title')
    {{ $action->short_description }} &mdash; edycja
@stop

@section('content')
    @if($errors->count())
        <div class="alert alert-danger">
            <strong>Zapisywanie nagrody nie powiodło się:</strong>
            <ul>
                @foreach($errors->all() as $key => $error)
                    @if($key == '0')
                        <li>Żadna nagroda nie została wpisana</li>
                    @else
                        <li>{{ $key }}: {{ $error }}</p>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-header">
        <h1>{{ $action->short_description }} &mdash; edycja</h1>
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
            {{ $first_time_checkin_count }} osób biorących udział pierwszy raz
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
                <td>Nagroda</td>
            </tr>
        </thead>
        <tbody class="table-middle">
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
                    <td>
                        <button
                                class="btn btn-sm btn-default @if(!$checkin->prize) visible-on-hover @endif"
                                data-toggle="modal"
                                data-target="#prizeModal"
                                data-id="{{ $checkin->id }}"
                                @if($checkin->prize)
                                    data-tooltip
                                    data-placement="left"
                                    title="@foreach($checkin->prize->items as $type) {{ str_replace(' ', '&nbsp;', $type->name) }} &nbsp; @endforeach"
                                    data-prizes="@foreach($checkin->prize->items as $type) {{ $type->id }} @endforeach"
                                @endif
                                @if($checkin->prize && $checkin->prize->claimed_at)
                                    data-claimed="1"
                                @endif
                            >
                            @if($checkin->prize && $checkin->prize->claimed_at)
                                <span class="text-success"><i class="fa fa-check"></i> Nagroda</span>
                            @elseif($checkin->prize)
                                <i class="fa fa-pencil"></i> Nagroda
                            @else
                                <i class="fa fa-plus"></i> Dodaj
                            @endif
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="no-results">
                    <td colspan="8">
                        Do tej akcji nikt jeszcze się nie wpisał.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

    <div class="modal fade" id="prizeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">Opisz nagrodę</h4>
          </div>
          <form method="post">
              {{ csrf_field() }}
          <div class="modal-body">
              <div class="form-group">
                 <label for="type-id" class="control-label">Nagroda</label>

                 {{ Form::select('type[][id]', $prize_types, null, ['multiple' => 'multiple', 'class' => 'form-control', 'id' => 'type-id', 'style' => 'width: 100%']) }}
              </div>
              <div class="form-group" data-claimed>
                  <i class="fa fa-check"></i> Nagroda została odebrana
              </div>
              <div class="form-group" data-not-claimed>
                  <label class="control-label" for="message-claimed"><input type="checkbox" name="claimed" value="1" id="message-claimed"> Nagroda została odebrana</label>
              </div>


          </div>
          <div class="modal-footer">
               <p><small>Brakuje nagrody? Przejdź do <a href="{{ url('admin/prize') }}">listy nagród</a>, aby dodać nowe pozycje.</small></p>
            <button type="reset" class="btn btn-default" data-dismiss="modal">Zamknij</button>
            <button type="submit" class="btn btn-primary">Zapisz</button>
          </div>
          </form>
        </div>
      </div>
    </div>

@stop

@section('extrahead')
    {{ HTML::style('bower_components/select2/dist/css/select2.min.css') }}
    {{ HTML::style('bower_components/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}

@stop

@section('script')
    {{ HTML::script('bower_components/select2/dist/js/select2.min.js') }}
@stop
