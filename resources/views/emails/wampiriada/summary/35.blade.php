@extends('layouts.mail')

@section('image', 'https://wampiriada.pl/img/w35-announcement.jpg')

@section('content')

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Cześć❗️
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Wszystko co dobre kiedyś się kończy. Tak i jesienna edycja Wampiriady również dobiega końca. To jednak nie oznacza, że pomaganie również. NZS RŁ już rusza z przygotowaniami do kolejnej edycji. Tymczasem chcemy wiedzieć jak Ty oceniasz 35. edycję Wapiriady?
    <br>Wypełnij ankietę i pomóż nam tworzyć ten projekt jeszcze lepiej.
</p>

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    <a style="text-decoration: none" href="https://forms.office.com/Pages/ResponsePage.aspx?id=JU-jGId4jkyeixkW3fMH1Xkt_6Pzks5CsQdIUf1XeLdUNVgzSFpHMkxJR0ZVMFNXSEE3RkxJWDg3QS4u">ANKIETA<a>
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Jeśli zaś chcesz tworzyć Wampiriadę oraz inne tego typu projekty wraz z nami już teraz możesz dołączyć do NZS RŁ:
</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
     <a style="text-decoration: none" href="https://forms.office.com/Pages/ResponsePage.aspx?id=JU-jGId4jkyeixkW3fMH1cnTw3qaKNBEsg07VnDeDXhUOVNKRzFKUlE2VEpGRFFCTVNMV0ZQSUw2Uy4u">DOŁĄCZAM❗️😍</a>
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Twoje zaangażowanie wiele dla Nas znaczy, serdecznie dziękujemy!
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Pozdrawiamy,<br>
    Sympatycy i członkowie <br>
    Niezależnego Zrzeszenia Studentów Regionu Łódzkiego<br>
    oraz wolontariusze projektu Wampiriada, edycja jesień 2019 :)
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4; text-align: center">
    <a href="{{ $repository->getRedirect('nzs') }}"><img src="http://wampiriada.pl/img/nzs-logo-new.jpg"></a>
</p>

@stop
