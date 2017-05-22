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
	        <div class="col-xs-12 text-center" id="image-container">
				@if(!$newspaper->getImagePath())
					{{ $logged_user->getFullName() }},
					trwa przetwarzanie danych, poczekaj kilka sekund.<br>
					<img src="{{ asset('img/heart.svg') }}">
				@else
					<img src="{{ Storage::url($newspaper->getImagePath()) }}">
				@endif
			</div>
		</div>
	</div>
@else


<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h2>Kolaboruj z Wampirem</h2>
			@if($login_url)
	            <p><a href="{{ $login_url }}">Zaloguj się z Facebookiem, aby kontynuować</a></p>
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


@section('extrajs')
	<script type="text/javascript">
		var _token = '{{ csrf_token() }}';

		$(function() {
			$.ajaxSetup({
				data: { _token: _token }
			});

			var timeinterval = 2;

			@if($logged_user && !$newspaper->getImagePath())

			var f = function() {
				$.post(path('nzs/poll_image'), {
					'filename': '{{ $newspaper->filename }}'
				}).done(function(data, status, xhr) {
					if(xhr.status == '202') {
						timeinterval = timeinterval * 1.5;
						setTimeout(f, 1000 * timeinterval);
					} else if(data.url) {
						$('#image-container').html(
							'<img src="' + data.url + '?t=' + data.t + '">'
						)
					}
				})
			}

			setTimeout(f, 1000 * timeinterval);

			@endif
		})

	</script>
@stop
