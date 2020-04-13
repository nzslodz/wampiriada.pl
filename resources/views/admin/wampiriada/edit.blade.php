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
            <strong>{{ $data->overall }}</strong>
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

    <form action="/admin/wampiriada/edit/{{ $action->id }}" method="post" class="form-horizontal">
        @csrf
        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            <label for="a_plus" class="control-label col-sm-2">
                A+
            </label>
            <div class="col-sm-10">
            <input type="number" id="a_plus" name="a_plus" class="form-control" data-calculate="source"
                value="{{ $data->a_plus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="a_minus" class="control-label col-sm-2">
                A-
            </label>
            <div class="col-sm-10">
                <input type="number" id="a_minus" name="a_minus" class="form-control" data-calculate="source"
                    value="{{ $data->a_minus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="b_plus" class="control-label col-sm-2">
                B+
            </label>
            <div class="col-sm-10">
                <input type="number" id="b_plus" name="b_plus" class="form-control" data-calculate="source"
                    value="{{ $data->b_plus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="b_minus" class="control-label col-sm-2">
                B-
            </label>
            <div class="col-sm-10">
                <input type="number" id="b_minus" name="b_minus" class="form-control" data-calculate="source"
                    value="{{ $data->b_minus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="unknown" class="control-label col-sm-2">
                Nieznana
            </label>
            <div class="col-sm-10">
                <input type="number" id="unknown" name="unknown" class="form-control" data-calculate="source"
                    value="{{ $data->unknown }}" />
            </div>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            <label for="ab_plus" class="control-label col-sm-2">
                AB+
            </label>
            <div class="col-sm-10">
                <input type="number" id="ab_plus" name="ab_plus" class="form-control" data-calculate="source"
                    value="{{ $data->ab_plus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="ab_minus" class="control-label col-sm-2">
                AB-
            </label>
            <div class="col-sm-10">
                <input type="number" id="ab_minus" name="ab_minus" class="form-control" data-calculate="source"
                    value="{{ $data->ab_minus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="zero_plus" class="control-label col-sm-2">
                0+
            </label>
            <div class="col-sm-10">
                <input type="number" id="zero_plus" name="zero_plus" class="form-control" data-calculate="source"
                    value="{{ $data->zero_plus }}" />
            </div>
            </div>
            <div class="form-group">
            <label for="zero_minus" class="control-label col-sm-2">
                0-
            </label>
            <div class="col-sm-10">
                <input type="number" id="zero_minus" name="zero_minus" class="form-control" data-calculate="source"
                    value="{{ $data->zero_minus }}" />
            </div>
            </div>
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-6">
            <div class="row">
            <div class="form-group">
            <label for="overall" class="control-label col-sm-2">
                Razem
            </label>
            <div class="col-sm-10">
            <input type="number" id="overall" name="overall" class="form-control" data-calculate="overall"
                value="{{ $data->overall }}" readonly="true" />
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">
                    Zapisz
                </button>
            </div>
            </div>
            </div>
            </div>
        </div>
    </form>

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
              @csrf
          <div class="modal-body">
              <div class="form-group">
                 <label for="type-id" class="control-label">Nagroda</label>

                 <select name="type[][id]" id="type-id" class="form-control" style="width:100%" multiple="multiple">
                     @foreach($prize_types as $value => $text)
                         <option value="{{ $value }}">{{ $text }}</option>
                     @endforeach
                 </select>

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
    <link type="text/css" href="/bower_components/select2/dist/css/select2.min.css" media="screen" />
    <link type="text/css" href="/bower_components/select2-bootstrap-theme/dist/select2-bootstrap.min.css" media="screen" />
@stop

@section('script')
    <script type="text/javascript" src="/bower_components/select2/dist/js/select2.min.js"></script>
@stop
