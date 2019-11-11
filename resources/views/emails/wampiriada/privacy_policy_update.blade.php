@extends('layouts.mail')

@section('content')

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
   Polityka prywatności
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Dostajesz tego maila, ponieważ uaktualniamy naszą politykę prywatności. Robimy to, aby jeszcze lepiej chronić dane krwiodawców oddających krew na Wampiriadzie.
</p>

<ul style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    <li>Administratorem danych jest Niezależne Zrzeszenie Studentów Regionu Łódzkiego;</li>
    <li>Od tej pory, dane osobowe będą przechowywane 5 lat od ostatniego zapisania;</li>
    <li>Jeśli chcesz mieć wgląd w swoje dane, wystarczy że napiszesz do nas na adres <a href="nzs@nzs.lodz.pl">nzs@nzs.lodz.pl</a>.</li>
</ul>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Pełna treść polityki prywatności znajduje się pod adresem <a href="http://wampiriada.pl/privacy_policy">http://wampiriada.pl/privacy_policy</a>.
</p>

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
   Newsletter NZS
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Dodatkowo, wprowadzamy Newsletter NZS - niespotykany wcześniej w łódzkim środowisku
    studenckim przewodnik po najciekawszych wydarzeniach kulturalnych i życiu akademickim.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    W ramach newslettera będziesz otrzymywać 1-2 e-maile w miesiącu informujące o tym &quot;co w trawie piszczy&quot;.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Jeśli z jakiegoś powodu nie chcesz otrzymywać informacji od nas, <a href="{{ url('newsletter/remove?email=' . urlencode($user->email)) }}">możesz wypisać się korzystając z tego linka</a>. Od tej pory przestaniemy przysyłać Ci jakiekolwiek e-maile.
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-top: 23px; margin-bottom: 25px; font-weight: normal;">
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
