@extends('layouts.mail')

@section('content')

 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Wampir nawiedzi łódzkie uczelnie po raz {{ $edition->number }}.
</h3>


<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    @if($edition->getStartDate()->month > 6)
        Jesień
    @else
        Wiosna
    @endif

    to czas, w którym odbywa się Wampiriada. Projekt pochłania blisko 1000 osób, które chcą popełnić dobry czyn. Do czego zapraszamy Cię po raz kolejny! Przyjdź na jedną z akcji Wampiriady, oddaj krew, zbierz czekolady, koszulkę i upominki od naszych sponsorów oraz podziel się tą dobrą wieścią ze swoimi znajomymi, aby było nas jeszcze więcej! :)
</p>


 <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Poznaj terminy akcji
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Poniżej lista terminów akcji Wampiriady. Jeśli nie chcesz zapomnieć o jednym z terminów, zapisz się na niego wcześniej &ndash; wyślemy Ci przypomnienie przed akcją.
</p>

@foreach($actions as $action)
<p style="font-size: 13px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 2px; line-height: 1.4;">
    <strong style="width: 400px; display: inline-block;"><span style="background-color: {{ $color($action->school_short) }}; color:white; padding: 1px 2px; border-radius: 2px;">{{ $action->day->format('d.m') }}</span>
    {{ $action->place }} <a style="font-size: 11px" href="{{ $repository->getRedirect('reminder-' . $action->id) }}&amp;r=t">przypomnij</a>
    </strong>
    {{ $action->start->format('H:i') }} - {{ $action->end->format('H:i') }}
    @if($action->marrow) <span style="background-color: #fff200; padding: 1px 2px; border-radius: 2px; font-size: 11px; font-weight: bold">+ SZPIK TO ME</span> @endif
</p>
@endforeach

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 25px; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
    Podaj dalej! Zobacz, w jaki sposób.
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
    <a href="{{ $repository->getRedirect('nzs') }}"><img src="http://nzs.lodz.pl/newsletter/nzs-logo.png"></a>
</p>

@stop
