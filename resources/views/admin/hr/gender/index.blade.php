@extends('layouts.admin')

@section('title')
    Płeć
@stop

@section('content')
    <div class="page-header">
        <h2>Płeć (do potwierdzenia)</h2>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Osoba</th>
                <td>Płeć</td>
                <td>Prawdopodobieństwo</td>
            </tr>
        </thead>
        <tbody class="table-middle">
            @forelse($people as $person)
                <tr>
                    <th><a href="{{ route('admin-hr-gender-edit', ['id' => $person->id, 'probability' => $probability ] ) }}">{{ $person->getFullName() }}</a></th>
                    @if($person->gender == 'male')
                        <td>Mężczyzna</td>
                    @elseif($person->gender == 'female')
                        <td>Kobieta</td>
                    @else
                        <td></td>
                    @endif

                    <td>
                        {{ $person->gender_probability }}
                    </td>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="5">
                    Brak osób, którym trzeba potwierdzić płeć.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop
