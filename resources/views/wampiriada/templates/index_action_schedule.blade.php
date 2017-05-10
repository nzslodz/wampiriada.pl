@if($display_actions)
<section id="schedule">
<div class="container">
   <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>Terminy {{ $repository->getEditionNumber() }}. edycji Wampiriady</h2>
                    <p class="date">{{ $repository->getEdition()->getStartDate()->format('m.Y') }} - {{ $repository->getEdition()->getEndDate()->format('m.Y') }} r.</p>
                </header>
            </div>

            <div class="sorting">
                <span>Sortowanie:</span>
                <a href="#" class="active" data-option-value="original-order"><i class="icon-time"></i> Chronologiczne</a>
                <a href="#" data-option-value="name"><i class="icon-map-marker"></i> Po uczelniach</a>
            </div>
        </div>
    </div>
   <div class="row nopadding">
        <div class="col-md-7 nopadding">
                <div class="row legend">
                    <p class="col-xs-2 date">Dzień</p>
                    <p class="col-xs-5 place" data-sort="PŁ">Miejsce trwania akcji</p>
                    <p class="col-xs-2 time">Czas akcji</p>
                    <p class="col-xs-2 marrow text-center">Szpik</p>
                </div>
            <ul class="isotope">

                @foreach($actions as $action)
                <li class="row {{ $get_class($action->school_short) }}" data-lat="{{ $action->lat }}" data-lng="{{ $action->lng }}">
                    <p class="col-xs-2 date"><span>{{ $action->day->format('d/m') }}</span></p>
                    <p class="col-xs-5 place {{ $get_class($action->school_short) }}" data-sort="{{ $action->school_short }}" data-address="{{ $action->address }}">{{ $action->place }} <a href="{{ url('reminder/' . $action->id)}}">przypomnij</a></p>
                    <p class="col-xs-2 time">{{ $action->start->format('H') }} - {{ $action->end->format('H') }}</p>
                    <p class="col-xs-2 marrow text-center">@if($action->marrow)<i class="fa fa-check"></i>@endif</p>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-5 nopadding">
            <div class="row legend">
                <p class="col-xs-12 text-center">
                Zaznacz jedno z miejsc, aby zobaczyć je na mapie.
                </p>
            </div>
			<div id="map"></div>
        </div>
    </div>

    </div>
</section>
@else
<section id="coming-soon">
<div class="container">
   <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>{{ $repository->getEditionNumber() }}. edycja Wampiriady</h2>
                    <p class="not-found">Już wkrótce pełny grafik terminów akcji Wampiriady.<br>Zapraszamy niebawem!</p>
                </header>
            </div>
        </div>
    </div>
</div>
</section>
@endif
