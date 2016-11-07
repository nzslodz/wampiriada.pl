@extends('layouts.mail') 

@section('content')

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Oddawanie krwi to powód do dumy.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    A akcja Wampiriady nie udałaby się bez Ciebie i nas wszystkich, którzy podobnie jak Ty chcą podzielić się częścią siebie ze światem. Dlatego też wolontariusze NZS Regionu Łódzkiego przygotowali coś specjalnego na 28. edycję Wampiriady.
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Jeden Wampir &ndash; 1000 twarzy.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Na <a href="{{ $repository->getRedirect('wampiriada') }}">stronie Wampiriady</a> umieściliśmy tajemniczy obraz, który tylko wspólnymi siłami jesteśmy w stanie odsłonić. Obraz podzielony jest na tysiąc pól. Oddając krew i logując się przez Facebooka, wstawiasz zdjęcie profilowe w jedno z pól, i niczym w zdrapce odsłaniasz część tajemniczego obrazu. Celem akcji jest odkrycie całości obrazu i tysiąc zdjęć profilowych - włącznie z Twoim  - w jednym miejscu. A to nie wszystkie niespodzianki, jakie na Ciebie czekają.
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Możesz pomóc. I wygrać. Oto, co możesz zrobić.
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Przekaż informację innym:<br>
    &mdash; Zaproś przyjaciół do wydarzenia <a href="{{ $repository->getRedirect('facebook-event') }}">https://web.facebook.com/events/1056420187739141/</a>; <br>
    &mdash; Opublikuj na swojej tablicy <a href="{{ $repository->getRedirect('plakat') }}">plakat Wampiriady</a> z hasztagiem #przyjacielWAMPIRA;<br>
    &mdash; Polub stronę <a href="{{ $repository->getRedirect('facebook') }}">http://facebook.com/wampiriada.nzs.rl</a>;<br>
    &mdash; Polub stronę <a href="{{ $repository->getRedirect('facebook-nzs') }}">http://facebook.com/NZSRegionuLodzkiego</a>;<br>
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Mamy do rozdania nagrody przygotowane przez naszych sponsorów. Są to między innymi: karnety na basen, zaproszenia do teatrów łódzkich, vouchery do kręgielni, zaproszenia do pizzerii, vouchery do jednego z escape roomów.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Pod koniec 28. edycji przeprowadzimy jeszcze jedno losowanie. Za każdym razem, kiedy ktoś z Twoich znajomych na Facebooku odda krew na Wampiriadzie, zwiększa szanse Was obojga na wygranie nagrody. Jeśli zaprosisz więcej niż jedną osobę, Twoje szanse będą jeszcze większe.
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
