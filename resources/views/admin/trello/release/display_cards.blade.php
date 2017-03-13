@extends('layouts.admin')

@section('title')
    Lista typów nagród
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ url('admin/prize/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj nowy typ nagrody</a>
            </div>
        </div>
        <h2>Lista typów nagród</h2>
    </div>

        <form class="form" action="" method="post">
        {{ csrf_field() }}
        @foreach($release_cards as $list)
            <h3>{{ $list->getDefinition()->name }}</h3>
            @foreach($list->getItems() as $card)
                <div class="checkbox"><label><input type="checkbox"  name="card_id[]" value="{{ $card->id }}"> {{ $card->name }}</label></div>
            @endforeach

            <div class="form-group">
                <label for="name">Nazwij release</label>
                <input name="name" type="name" class="form-control" id="name" placeholder="Przykładowy release">
            </div>

            <button type="submit" class="btn btn-default">Utwórz release</button>
        @endforeach

        </form>

        {{--}}<thead>
            <tr>
                <th>Nazwa wewnętrzna</th>
                <td>Opis (dla otrzymujących)</td>
                <td>Dostępne</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($prizes as $prize)
                <tr>
                    <th><a href="{{ url('admin/prize/edit/' . $prize->id) }}">{{ $prize->name }}</a></th>
                    <td>{{ $prize->description }}</td>
                    <td>
                        <button class="btn btn-default btn-sm" data-toggle="checkbox" data-url="{{ url('admin/prize/toggle/' . $prize->id) }}">
                            <span class="text-success {{ $prize->active ? '': 'hidden' }}" data-active><i class="fa fa-check"></i> Dostępne</span>
                            <span class="text-danger {{ $prize->active ? 'hidden': '' }}" data-inactive><i class="fa fa-times"></i> Niedostępne</span>
                        </button>
                    </td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="3">
                    Aby dodać nowy typ nagrody, naciśnij przycisk <strong>Dodaj nowy typ nagrody</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>
        --}}
@stop
