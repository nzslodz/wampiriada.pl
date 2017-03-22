@extends('layouts.master')

@section('content')

@if(session('message'))
<div class="alert alert-{{ session('status', 'info') }}" role="alert">
	{{ session('message') }}
</div>
@endif


@if($logged_user)
	<div class="container">
	    <div class="row">
	        <div class="col-xs-12 text-center">
				Tu będzie Twój obrazek,
				{{ $logged_user->getFullName() }}
			</div>
		</div>
	</div>
@else


<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h2>Kolaboruj z Wampirem</h2>
			@if($login_url)
	            <p><a href="{{ $login_url }}">
					@if($loggable_user)
						Kontynuuj jako {{ $loggable_user->first_name }}
					@else
						Zaloguj się z Facebookiem, aby kontynuować
					@endif
				</a></p>
			@endif
        </div>
    </div>
</div>

@endif

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
