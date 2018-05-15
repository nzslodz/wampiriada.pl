@extends('layouts.checkin')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>Polityka prywatności</h2>

			<p>Wpisując się na niniejszą listę odbioru koszulek, powierzasz nam swoje dane. Niezależne Zrzeszenie Studentów Regionu Łódzkiego szanuje prywatność danych uczestników Wampiriady. Niniejsza polityka prywatności pozwala na lepsze zrozumienie, jakie dane zbieramy oraz w jakim celu i do czego je wykorzystujemy.</p>

			<h3>Cel gromadzenia informacji</h3>

			<p>Wierzymy, że dzięki wykorzystaniu nowoczesnych technologii można zwiększyć propagację akcji krwiodawstwa oraz idei wolontariatu. Informacje, które zbieramy wykorzystywane są, aby docierać do większego grona potencjalnych krwiodawców, w celu ułatwienia procedury oddawania krwi oraz aby zachęcić Cię do działania na rzecz innych.</p>

			<p>Nie udostępniamy Twoich danych osobom trzecim bez Twojej zgody.</p>

			<h3>Jakie informacje zbieramy</h3>
			<ul>
				<li>Twój profil publiczny z Facebooka (e-mail oraz wyświetlana nazwa).</li>
				<li>Listę krwiodawców, z którymi przyjaźnisz się na Facebooku.</li>
				<li>Zdjęcie profilowe - w celu wykonania mozaiki znajdującej się na stronie <a href="http://wampiriada.pl/">wampiriada.pl</a></li>
				<li>Informacje o donacji.</li>
			</ul>

			<h3>Ciasteczka</h3>
			<p>Korzystamy z technologii cookies (ciasteczek). Ciasteczka te są małymi plikami tekstowymi, przechowywanymi na Twoim komputerze. Są one potrzebne do prawidłowego funkcjonowania strony. Dodatkowo, używamy technologii Google Analytics aby uzyskiwać informacje o odwiedzinach na stronie.</p>

			<p><a href="{{ url('facebook/login') }}">Wróć na stronę</a>.</p>
	</div>
	</div>
</div>


@stop
