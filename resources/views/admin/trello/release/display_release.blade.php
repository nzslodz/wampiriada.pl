@extends('layouts.admin')

@section('title')
    Lista typów nagród
@stop

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a href="{{ route('admin-trello-releases-create', ['key' => $repo->getKey() ]) }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Dodaj nowy typ nagrody</a>
            </div>
        </div>
        <h2>Release: {{ $release->getDefinition()->name }} ({{$release->getCount()}})</h2>
    </div>

                @foreach($release->getItems()->chunk(3) as $cards)
                    <div class="row">
                        @foreach($cards as $card)
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a href="{{ $card->url }}">{{ $card->name }}</a></h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>{{ $card->desc }}</p>
                                        <p>{{ $card->badges->checkItemsChecked}}/{{ $card->badges->checkItems}} : {{ $card->badges->comments}} : {{ $card->badges->attachments}} : {{$card->badges->due}} {{$card->badges->dueComplete}}</p>
                                        <p>@foreach($card->labels as $label)
                                            {{$label->color}}
                                        @endforeach</p>
                                    </div>
                                </div>
                            </div>
                            {!!  nl2br(json_encode($card, true)) !!}
                        @endforeach
                    </div>
                @endforeach
            </ul>

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
