@extends('layouts.checkin')

@section('content')

@if(session('message'))
<div class="alert alert-{{ session('status', 'info') }}" role="alert">
	{{ session('message') }}
</div>
@endif

<div class="exit">
</div>
<form class="form-horizontal">
<div class="frame" id="application">
	<div class="views" v-bind:data-view="currentView">
		<section-begin></section-begin>
		<section-statistics></section-statistics>
		<section-agreements></section-agreements>
		<section-login-confirm></section-login-confirm>
		<section-success></section-success>
	</div>

	<!-- navigation + meta -->
</div>
</form>

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

 {{ Form::open(array('url' => '/facebook/checkin', 'class' => 'form-horizontal')) }}
	 <div class="form-group {{ $errors->has('blood_type') ? 'has-error' : '' }}">
		 {{ Form::label('blood_type', 'Grupa krwi', ['class' => 'control-label col-sm-2']) }}
		 <div class="col-sm-6">
			 {{ Form::select('blood_type', ['' => '---', 'a_plus' => 'A+', 'a_minus' => 'A-', 'b_plus' => 'B+', 'b_minus' => 'B-', 'ab_plus' => 'AB+', 'ab_minus' => 'AB-', 'zero_plus' => '0+', 'zero_minus' => '0-', 'unknown' => 'Nie wiem'], '', ['class' => 'form-control']) }}
		 </div>
		 <div class="col-sm-4">
			 {{ $errors->first('blood_type') }}
		 </div>
	 </div>
	 <div class="form-group {{ $errors->has('size') ? 'has-error' : '' }}">
		 {{ Form::label('size', 'Rozmiar koszulki', ['class' => 'control-label col-sm-2']) }}
		 <div class="col-sm-6">
			 {{ Form::select('size', $sizes, '', ['class' => 'form-control']) }}
		 </div>
		 <div class="col-sm-4">
			 {{ $errors->first('size') }}
		 </div>
	 </div>
	 <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
		 {{ Form::label('name', 'Imię i nazwisko', ['class' => 'control-label col-sm-2']) }}
		 <div class="col-sm-6">
			 {{ Form::text('name', '', ['class' => 'form-control']) }}
		 </div>
		 <div class="col-sm-4">
			 {{ $errors->first('name') }}
		 </div>
	 </div>


		 <div class="form-group">
			 <div class="col-sm-6 col-sm-offset-2">
				 <div class="checkbox">
					 <label>
						 {{ Form::checkbox('first_time', '1', false, ['class' => '']) }} Oddaję pierwszy raz
					 </label>
				 </div>
			 </div>
		 </div>
	 <div class="form-group">
		 <div class="col-sm-offset-2 col-sm-6">
			 {{ Form::submit('Zapisz', ['class' => 'btn btn-default']) }}
		 </div>
	 </div>
 </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center">
			<div class="footer">
				<p>Copyright &copy; 2014 - {{ date('Y') }} <a href="http://nzs.lodz.pl">NZS Regionu Łódzkiego</a>. <a href="{{ url('privacy_policy') }}">Polityka prywatności</a>.</p>
			</div>
		</div>
	</div>
</div>

@stop

@section('datajs')
	<script type="text/javascript">
		var shirtSizes = {!! $sizes !!};
	</script>
@stop
