@extends('layouts.master')

@section('content')

@if(session('message'))
<div class="alert alert-{{ session('status', 'info') }}" role="alert">
	{{ session('message') }}
</div>
@endif



<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h2>Lista odbioru koszulek</h2>
			@if($is_facebook_login_enabled)
	            <p><a href="{{ $login_url }}">Zaloguj się z Facebookiem, aby kontynuować</a></p>
	            <a href="#alternative-form" data-toggle="collapse">Nie posiadam Facebooka</a>
			@endif
        </div>
    </div>
</div>



<div class="container @if($errors->isEmpty() && $is_facebook_login_enabled) collapse @endif" id="alternative-form">
	<div class="well well-dark">
			<h3>Podaj swój e-mail:</h3>
 {{ Form::open(array('class' => 'form-horizontal')) }}
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Adres e-mail', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::email('email', '', ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('email') }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Wyślij', ['class' => 'btn btn-default']) }}
                </div>
            </div>
 {{ Form::close() }}
 </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center">
			<div class="footer">
				<p>Copyright &copy; 2014 - {{ date('Y') }} <a href="http://nzs.lodz.pl">NZS Regionu Łódzkiego</a>. <a href="{{ url('facebook/privacy_policy') }}">Polityka prywatności</a>.</p>
			</div>
		</div>
	</div>
</div>

@stop
