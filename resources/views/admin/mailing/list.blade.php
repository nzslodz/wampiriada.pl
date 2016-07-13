@extends('layouts.admin')

@section('title')
    Mailingi
@stop

@section('content')
    <div class="page-header">
        <h2>Mailingi</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nazwa mailingu</th>
                <td>Nazwa klasy</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($mailings as $key => $mailing)
                <tr>
                    <th><a href="{{ url('admin/mailing/' . $key) }}">{{ $mailing->getCampaignName() }}</a></th>
                    <td>{{ get_class($mailing) }}</td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="2">
                    Aby dodać nowy typ nagrody, naciśnij przycisk <strong>Dodaj nowy typ nagrody</strong> w prawym górnym rogu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
