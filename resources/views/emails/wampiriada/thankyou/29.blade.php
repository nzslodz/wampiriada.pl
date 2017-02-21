@extends('layouts.mail')

@section('content')

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Zwycięzcą się bywa.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Kiedy oddajesz krew na Wampiriadzie, wszyscy wygrywają. Dla Ciebie to koszulka, czekolady, zniżki i gadżety przygotowane przez naszych partnerów. Dla biorcy to kolejne życie &ndash; niczym w grze komputerowej. A to tylko jeden zwyczajny, a raczej nadzwyczajny, dzień z Twojego życia. Jeden prosty czyn, z którego płynie duma. Ile jeszcze takich dni przez Tobą?
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Człowiekiem się jest.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Życie to coś więcej, niż jednorazowa akcja. Życie opiera się nie na sukcesach, a na wartościach. Dlatego życzymy Ci, aby wartości, które przywiodły Cię do decyzji oddania krwi, poprowadziły Cię w przyszłości ku jeszcze lepszej wersji siebie. Wszak to Ty tutaj dowodzisz.
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Tak właśnie rodzi się synergia.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Każdy z nas ma w sobie odrobinę indywidualności, która czyni nas niesamowitymi. Z kolei Wampiriada jest niezwykła dzięki honorowym krwiodawcom. To właśnie Ty i aż ponad 1000 innych osób podjęło wyjątkową decyzję o wzięciu udziału w Wampiriadzie, dzięki czemu pozyskaliśmy zawrotne 766 jednostek krwi. Tylko dzięki Tobie wyniki 29. edycji Wampiriady są tak dobre.
</p>

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
   To takie proste.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
   Zapraszamy Cię na Wampiriadę już na wiosnę. Oddawanie krwi to powód do dumy, więc zabierz ze sobą swoich przyjaciół i razem z nimi weź udział w następnej, 30. edycji Wampiriady. Taka okazja nie zdarza się codziennie.
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Więcej informacji
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Śledź nasze działania na:<br>
<a href="{{ $repository->getRedirect('wampiriada') }}">http://wampiriada.pl</a><br>
<a href="{{ $repository->getRedirect('facebook') }}">http://facebook.com/wampiriada.nzs.rl</a><br>
oraz poprzez e-mail: <a href="mailto:nzs@nzs.lodz.pl">nzs@nzs.lodz.pl</a>.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Pozdrawiamy,<br>
Organizatorzy Wampiriady

</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4; text-align: center">
    <a href="{{ $repository->getRedirect('nzs') }}"><img src="http://nzs.lodz.pl/newsletter/nzs-logo.png"></a>
</p>

@stop
