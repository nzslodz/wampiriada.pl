@extends('layouts.mail')

@section('image', 'https://wampiriada.pl/img/w35-announcement.jpg')

@section('content')

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Nadchodzi 35. edycja Wampiriady – studenckiego honorowego krwiodawstwa w Łódzkiej Galaktyce💫❗️ Udział może wziąć KAŻDY, nie tylko Jedi❗️

</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    To szansa by ocalić czyjeś życie❗️<br>
    Wybierz termin, oddaj krew💉, zarejestruj się do bazy potencjalnych dawców szpiku📋 i&nbsp;zostań Wampirzym bohaterem❗️ Przy okazji sprawdzisz zawartość midichlorianów🔬 we&nbsp;krwi.
</p>
<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Po oddaniu krwi otrzymasz od nas pamiątkową koszulkę Wampira👕, czekolady🍫 oraz&nbsp;niespodzianki🎁 od naszych partnerów.<br>
    Możesz liczyć również na zwolnienie lekarskie! 📄
</p>
<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Namów przyjaciół 👥 i RAZEM zostańcie naszą NOWĄ NADZIEJĄ❗️😍‍<br>
    #przyjacielWampira
</p>


 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
     Gdzie odbędzie się atak Wampira❓
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Poniżej lista terminów akcji Wampiriady. Jeśli nie chcesz zapomnieć o jednym z terminów, zapisz się na niego wcześniej &ndash; wyślemy Ci przypomnienie przed akcją.
</p>

@foreach($actions as $action)
<p style="font-size: 13px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 2px; line-height: 1.4;">
    <strong style="width: 400px; display: inline-block;"><span style="background-color: {{ $color($action->present()->school_short) }}; color:white; padding: 1px 2px; border-radius: 2px;">{{ $action->created_at->format('d.m') }}</span>
    {{ $action->present()->place }} <a style="font-size: 11px" href="{{ url('reminder/' . $action->id) }}">przypomnij</a>
    </strong>
    {{ $action->start->format('H:i') }} - {{ $action->end->format('H:i') }}
    @if($action->marrow) <span style="background-color: #fff200; padding: 1px 2px; border-radius: 2px; font-size: 11px; font-weight: bold">+ SZPIK TO ME</span> @endif
</p>
@endforeach

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 25px; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    🔜 Przebudzenie Wampira już wkrótce❗️
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
   Przekaż informację innym:<br>
   @if($repository->getRedirect('facebook-event')->exists())
       &mdash; Zaproś przyjaciół do wydarzenia <a href="{{ $repository->getRedirect('facebook-event') }}">{{ $repository->getRedirect('facebook-event') }}</a>; <br>
   @endif

   @if($repository->getRedirect('plakat')->exists())
       &mdash; Opublikuj na swojej tablicy <a href="{{ $repository->getRedirect('plakat') }}">plakat Wampiriady</a> z hasztagiem #przyjacielWAMPIRA;<br>
   @endif
   &mdash; Polub stronę <a href="{{ $repository->getRedirect('facebook') }}">http://facebook.com/wampiriada.nzs.rl</a>;<br>
   &mdash; Polub stronę <a href="{{ $repository->getRedirect('facebook-nzs') }}">http://facebook.com/NZSRegionuLodzkiego</a>;<br>
   &mdash; Powiedz znajomym o Wampiriadzie.

</p>

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0px; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
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
    <a href="{{ $repository->getRedirect('nzs') }}"><img src="http://wampiriada.pl/img/nzs-logo-new.jpg"></a>
</p>

@stop
