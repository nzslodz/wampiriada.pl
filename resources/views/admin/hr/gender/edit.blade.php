@extends('layouts.admin')

@section('title')

    Określ płeć dla {{ $person->getFullName() }}
@stop

@section('content')
    <div class="page-header">
        <h1>
            Określ płeć dla {{ $person->getFullName() }} &lt;{{ $person->email }}&gt;
        </h1>
    </div>

    <div class="container">

        <form action="" method="post" class="form-horizontal">
            @csrf
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button class="btn btn-default btn-large" name="gender" value="male"><i class="fa fa-male"></i> Mężczyzna</button>
                    <button class="btn btn-default btn-large" name="gender" value="female"><i class="fa fa-female"></i> Kobieta</button>
                    <button class="btn btn-default" name="gender" value="skip">Pomiń</button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <select name="_next" class="form-control">
                        @foreach(storyboard()->choices('_next') as $value => $text)
                            <option
                                value="{{ $value }}"
                                @if($value == storyboard()->value('_next'))
                                    selected
                                @endif
                                >
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

    </div>

@stop
