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
            @forelse($mailings as $mailing)
                <tr>
                    <th><a href="{{ url('admin/mailing/show?class=' . get_class($mailing)) }}">{{ $mailing->getCampaignName() }}</a></th>
                    <td>{{ get_class($mailing) }}</td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="2">
                    Brak mailingów.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
