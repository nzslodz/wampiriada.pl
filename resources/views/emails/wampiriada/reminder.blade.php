@extends('layouts.mail')

@section('content')

<h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
   Przygotuj się do Wampiriady!
</h3>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Twoja akcja już blisko. Wybrane przez Ciebie miejsce i termin to:
</p>

<p style="font-size: 18px; font-weight: bold; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 10px; line-height: 1.4;">
    {{ $action_day->present()->place }}
</p>

<p style="font-size: 18px; font-weight: bold; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
{{ $action_day->created_at->format('d-m-Y') }} ({{ $action_day->start->format('H:i') }} - {{ $action_day->end->format('H:i') }})
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Przed oddaniem krwi koniecznie zjedz lekkie śniadanie i pamiętaj o nawodnieniu ciała - wypicie pół litra wody przed oddawaniem nie dość, że przyśpiesza proces oddawania krwi, to jeszcze sprawia, że po oddaniu będziesz czuć się dobrze.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Przez 48 godzin przed oddaniem krwi wstrzymaj się ze spożywaniem alkoholu. Jeśli chorujesz albo przyjmujesz leki przeciwbólowe lub przeciwzapalne, dobrym pomysłem jest przełożyć termin oddawania krwi.
</p>

<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Jeśli chcesz oddać krew jako jedna z pierwszych osób, to warto pojawić się nieco przed akcją. Zaczynamy o {{ $action_day->start->format('H:i') }}. :)
</p>

@if($action_day->marrow)
<p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
    Na akcji możesz zapisać się również do bazy dawców szpiku. Zapisywanie się polega na wypełnieniu dodatkowego formularza rejestracyjnego, a pielęgniarka sama pobierze Ci dodatkową próbkę do badania. Pamiętaj, ta decyzja do niczego Cię nie zobowiązuje. Decyzję o oddaniu szpiku podejmiesz dopiero wtedy, kiedy znajdzie się biorca pasujący do Ciebie.
</p>
@endif

@if(!$actions->isEmpty())
    <h3 style="font-size: 24px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #d33 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; font-weight: normal;">
       Termin nie odpowiada?
    </h3>

    <p style="font-size: 13px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4;">
        Poniżej znajdziesz inne terminy, w których możesz oddać krew. Wystarczy, że wybierzesz jeden z nich. Możesz też ustawić kolejny e-mail z przypomnieniem - tak dla pewności.
    </p>

    @foreach($actions as $new_action)
    <p style="font-size: 13px; font-family: Arial, sans-serif; color: #3D3D3D !important; margin-top: 0; margin-left: 0; margin-bottom: 2px; line-height: 1.4;">
        <strong style="width: 400px; display: inline-block;"><span style="background-color: {{ $color($new_action->present()->school_short) }}; color:white; padding: 1px 2px; border-radius: 2px;">{{ $new_action->created_at->format('d.m') }}</span>
        {{ $new_action->present()->place }}
        @if($new_action->created_at > $action_day->created_at)
            <a style="font-size: 11px" href="{{ url('reminder/' . $action->id) }}">przypomnij</a>
        @endif
        </strong>
        {{ $new_action->start->format('H:i') }} - {{ $new_action->end->format('H:i') }}
        @if($new_action->marrow) <span style="background-color: #fff200; padding: 1px 2px; border-radius: 2px; font-size: 11px; font-weight: bold">+ SZPIK TO ME</span> @endif
    </p>
    @endforeach
@endif

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
