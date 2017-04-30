@extends('layouts.mail')

@section('content')

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Majówka z Wampirem!
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Majówka to świetny czas, aby spotkać się z przyjaciółmi, odnowić stare znajomości i naładować akumulatory – już niebawem przecież Juwenalia, a potem egzaminy! Będzie intensywnie :)
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    A w połączeniu z tym wszystkim, dlaczego nie zrobić jeszcze czegoś dla innych i wziąć udział w wyjątkowym wydarzeniu?
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Ekipa Wampiriady i Wojskowe Centrum Kształcenia Medycznego zapraszają Cię na <a href="{{ $repository->getRedirect('wampiriada-majowka-2017') }}">piknik, który odbędzie się</a> <strong>2-go maja</strong> w godzinach 10:00 – 17:00 przy ul. 6-go Sierpnia 92. Nie tylko oddasz krew, ale też weźmiesz udział w koncertach, konkursach, nauce pierwszej pomocy, zobaczysz pokazy walk rycerskich, żołnierzy i strażaków, a dla każdego przewidziana jest przepyszna wojskowa grochówka. Wstęp wolny, zapraszamy wszystkich, nie tylko dawców krwi :)
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 23px; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">


<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
   Poznaj terminy Wampiriady
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Po majówce ruszamy z Wampiriadą! Specjalnie dla Ciebie i innych krwiodawców, którzy już oddawali krew na Wampiriadzie, terminy przekazujemy nieco wcześniej, na chwilę przed ich oficjalną publikacją.
</p>

@foreach($actions as $action)
<p style="font-size: 13px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 2px; line-height: 1.4;">
    <strong style="width: 400px; display: inline-block;"><span style="background-color: {{ $color($action->school_short) }}; color:white; padding: 1px 2px; border-radius: 2px;">{{ $action->day->format('d.m') }}</span>
    {{ $action->place }} {{ $action->id }} <a style="font-size: 11px" href="{{ $repository->getRedirect('reminder-' . $action->id) }}&amp;r=t">przypomnij</a>
    </strong>
    {{ $action->start->format('H:i') }} - {{ $action->end->format('H:i') }}
    @if($action->marrow) <span style="background-color: #fff200; padding: 1px 2px; border-radius: 2px; font-size: 11px; font-weight: bold">+ SZPIK TO ME</span> @endif
</p>
@endforeach

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 23px; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Poszukujemy także wolontariuszy do akcji – jeśli tylko uważasz, że pomoc przy Wampiriadzie to coś, w co chcesz się zaangażować to mamy coś dla Ciebie: wpisz się na <a href="{{ $repository->getRedirect('nzs-rekrutacja') }}">http://nzs.lodz.pl/rekrutacja</a> lub napisz do nas na Facebooku.
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Więcej informacji
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Pamiętaj, informacje na bieżąco znajdziesz na naszym fanpage i stronie:<br>
<a href="{{ $repository->getRedirect('wampiriada') }}">http://wampiriada.pl</a><br>
<a href="{{ $repository->getRedirect('facebook') }}">http://facebook.com/wampiriada.nzs.rl</a><br>
oraz poprzez e-mail: <a href="mailto:nzs@nzs.lodz.pl">nzs@nzs.lodz.pl</a>.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Ze studenckim pozdrowieniem,<br>
Ekipa Wampiriady i członkowie oraz sympatycy NZS Regionu Łódzkiego :)
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4; text-align: center">
    <a href="{{ $repository->getRedirect('nzs') }}"><img src="http://nzs.lodz.pl/newsletter/nzs-logo.png"></a>
</p>

@stop
