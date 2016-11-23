@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Lista krwiodawców</h1>
            <p>Prosimy o wypełnienie wszystkich pól poniżej.</p>
        </div>

        {{ Form::open(array('url' => '/facebook/checkin', 'class' => 'form-horizontal')) }}
            <div class="form-group {{ $errors->has('blood_type') ? 'has-error' : '' }}">
                {{ Form::label('blood_type', 'Grupa krwi', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::select('blood_type', $blood_types, $profile->blood_type_id, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('blood_type') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('size') ? 'has-error' : '' }}">
                {{ Form::label('size', 'Rozmiar koszulki', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::select('size', $sizes, $profile->default_size_id, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('size') }}
                </div>
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Imię i nazwisko', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('name', $profile->current_name ? $profile->current_name : Auth::user()->getFullName(), ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('name') }}
                </div>
            </div>

            @if(!$user->email)
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Adres e-mail', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::email('email', $user->email, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('email') }}
                </div>
            </div>
            @endif
            @if($first_time)
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('first_time', '1', false, ['class' => '']) }} Oddaję pierwszy raz
                            </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
                </div>
            </div>


        {{ Form::close() }}
    </div>

    <div class="container">
    	<div class="row">
    		<div class="col-xs-6  col-xs-push-2">
    			<div class="footer">
    				<p>Copyright &copy; 2014 - {{ date('Y') }} <a href="http://nzs.lodz.pl">NZS Regionu Łódzkiego</a>. <a href="{{ url('privacy_policy') }}">Polityka prywatności</a>.</p>
    			</div>
    		</div>
    	</div>
    </div>

@stop
