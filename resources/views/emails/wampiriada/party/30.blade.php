@extends('layouts.mail')

@section('content')

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Wampirparty VR!
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Zapraszamy każdego #przyjacielWampira na jedyne w swoim rodzaju WAMPIRPARTY, które odbędzie się w niepowtarzalnym miejscu, w samym centrum rozrywkowej mapy Łodzi – PIERWSZYM salonie wirtualnej rzeczywistości – Virtual House. W samym sercu ulicy Piotrkowskiej będziecie mieć nadzwyczajną okazję do spotkania się z najnowocześniejszą technologią Virtual Reality – 9 stanowisk VR dedykowanych pod różne rodzaje rozrywki, 30 gier VR i już ponad 2 tysiące zadowolonych graczy!
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Każda osoba, która w trakcie jubileuszowej 30. edycji Wampiriady oddała krew na jednej z naszych akcji (pełne 450 ml) będzie miała możliwość wejścia do elitarnego klubu wirtualnego wampira i skorzystania z podwójnych zaproszeń od naszego partnera strategicznego Virtual House. W czwartkowy wieczór – <strong>8 czerwca o godzinie 20:00</strong> rozpocznie się wysokiej klasy spotkanie w wirtualnej rzeczywistości. Łódź you like to play a game? Czytaj dalej!
</p>

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Jak się dostać do klubu Wampira?
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Dołącz do wydarzenia <a href="{{ $repository->getRedirect('party-event') }}">Wampirparty w Virtual House</a> i czekaj na dalsze wskazówki :)
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Do 5 czerwca, o znanej tylko Wampirowi godzinie, będziemy zwalniać pulę 5 podwójnych zaproszeń – kto pierwszy ten lepszy! :)
</p>

<div style="margin-bottom: 25px">
<a href="{{ $repository->getRedirect('party-event') }}"><img style="width: 100%; height: auto" src="{{ $repository->getRedirect('party-img') }}" alt="Wampiriada - {{ $edition->number }}. edycja"></a>
</div>

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Organizatorzy
</h3>
<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    <a href="{{ $repository->getRedirect('facebook-nzs') }}">NZS Regionu Łódzkiego</a> – organizacja studencka zrzeszająca wszystkich studentów w Łodzi - nieważne na jakiej uczelni studiujesz – Uniwersytet Łódzki, Politechnika Łódzka, Uniwersytet Medyczny w Łodzi – dla nas jesteś tak samo ważny! NZS to ogólnopolska organizacja studencka, która działa we wszystkich ośrodkach akademickich w Polsce od 1981 roku. Dzięki naszym alumnom studiujesz w demokratycznej Polsce, jesteś wolnym człowiekiem, który może swobodnie wyrażać swoje myśli i słowa, uczyć się i studiować zakazaną w PRL-u literaturę i języki obce. W Łodzi działamy jako stowarzyszenie skupiające trzy największe ośrodki uczelniane – UŁ, PŁ, UMed. Działamy w oparciu o trzy filary/sekcje, w których realizujemy i inicjujemy projekty dla społeczności akademickiej – rozwój, kultura, działania charytatywne.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    <a href="{{ $repository->getRedirect('virtual-house') }}">Virtual House</a> to jedyne i niepowtarzalne miejsce na rozrywkowej centralnej mapie Polski. Jest to miejsce, w którym zetkniecie się z najnowszą technologią Wirtualnej Rzeczywistości. Do dyspozycji jest 9 stanowisk dedykowanych pod różne rodzaje rozrywki. Możecie spotkać u nas aplikacje od spokojnych i relaksujących po jeżące włosy na głowie oraz takie przeznaczone dla najmłodszych osób. Każdy, kto nas odwiedza nie spodziewa sie tego, co czeka go po otwarciu naszych drzwi do strefy Virtual Reality. Salon podzielony jest na 4 strefy tematyczne, tworzące spójną całość pod względem tego, co możemy tu doświadczyć. Na ścianach widnieją prace w formie graffiti realizowanie przez łódzkie StandART Studio.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0px; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Dodatkowo w strefie barowej czekają na Was konsole xBox One, z których korzystać możecie do bólu, póki nie pojawią się odciski na kciukach!
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0px; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Przypominamy, że wzięcie udziału w wydarzeniach NZS Regionu Łódzkiego jest otwarte dla wszystkich studentów. Nie musisz być członkiem, możesz też śledzić nasz fanpage, aby być na bieżąco i cieszyć się błogim życiem studenckim.
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
