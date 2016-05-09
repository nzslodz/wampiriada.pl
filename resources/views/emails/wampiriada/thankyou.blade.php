@extends('layouts.mail') 

@section('content')

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
Wampir znów grasuje po łódzkich uczelniach – to już 28. raz!
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Mocno wierzymy, że szerzenie wśród młodych ludzi idei honorowego krwiodawstwa jest obowiązkiem każdego - Ciebie, mnie, nas wszystkich. Krew jest niezbędna nie tylko ofiarom wypadków, ale także cierpiącym na różnego rodzaju choroby. Przetaczana podczas transfuzji pozwala ratować ludzkie życie i zdrowie. Wszyscy możemy przyczynić się do wzrostu ilości krwi i zapełnić zapasy życiodajnego płynu na wakacje! Dlatego po raz dwudziesty ósmy organizujemy akcję WAMPIRIADA – studenckie honorowe krwiodawstwo na 4 uczelniach wyższych w Łodzi! Możesz również zarejestrować się w bazie dawców szpiku, oddając niewielką próbkę krwi, aby ocalić kolejne ludzkie życie.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Ruszamy!
</p>
<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Sprawdź, kiedy Wampir pojawi się na Twoim wydziale:
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Pomóż nam rozwijać Wampiriadę - dołącz do wydarzenia i zaproś swoich znajomych!
Link do wydarzenia: <a href="{{ $repository->getRedirect('facebook-event') }}">https://web.facebook.com/events/1056420187739141/</a>
<p>


<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
Więcej o Wampiriadzie znajdziesz tutaj:<br>
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