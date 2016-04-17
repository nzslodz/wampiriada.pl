@extends('layouts.master')

@section('title')
Wampiriada w Łodzi
@stop

@section('meta-description')
Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.
@stop

@section('content')
<section id="intro">
    <div class="container-fluid sr-only">
    <div class="row invisible">
        <div class="col-xs-12">
            <h1>Wampiriada - studenckie honorowe krwiodawstwo</h1>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-xs-12 movie">
            <h2>Poznaj Wampira</h2>
            <div class="box">
                <iframe width="853" height="480" src="//www.youtube.com/embed/KkjbiwbjUFY" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    -->
    </div>
</section>

@include('wampiriada.templates.index_action_schedule')

<section class="imagegrid">
    <div class="image">
    <img src="{{ url('storage/ImageGrid.jpg') }}">
    </div>

    <div class="container">
        @foreach($achievements as $number => $achievement)
            @if($numberOfCheckins >= $number)
                <div class="achievement">
                    <div class="achievement-number">{{ $number }}</div>
                    <div class="achievement-body">
                        {{ $achievement }}
                    </div>
                    <div class="achievement-lock"></div>
                </div>
            @else
                <div class="achievement locked">
                    <div class="achievement-number">{{ $number }}</div>
                    <div class="achievement-body">
                        To osiągnięcie zostanie odkryte za {{ $number - $numberOfCheckins }} osób.
                    </div>
                    <div class="achievement-lock"><i class="fa fa-lock" aria-hidden="true"></i></div>
                </div>
            @endif
        @endforeach
    </div>

</section>


<section class="description @if($display_results) with-results @endif">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="clearfix">
                    <header>
                        <h2>Co trzeba wiedzieć?</h2>
                        <p class="date">Oddawaj krew i zapisz się do bazy dawców szpiku!</p>
                    </header>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-push-4">
                <img class="fancyphoto" src="{{ url('img/oddaj.jpg') }}" alt="Pół litra oddajesz, Wampirem się stajesz">
            </div>
            <div class="col-md-4 col-md-pull-4 col-xs-12">
                <h3>Krew</h3>
                <p>Przed oddaniem krwi koniecznie zjedz lekkie śniadanie i napij się pół litra wody. Przyśpieszy to proces oddawania krwi i sprawi, że po oddaniu będziesz czuć się dobrze.</p>
                <p>Pamiętaj o zabraniu dokumentu tożsamości.</p>
                <p>Jeśli:</p>
                <ul>
                    <li>chorujesz,</li>
                    <li>jesteś do 48 godzin po spożyciu alhokolu,</li>
                    <li>lub bierzesz leki,</li>
                </ul>
                <p>warto wstrzymać się z uczestnictwem w akcji Wampiriady. Wybierz jedną z akcji w późniejszym terminie, albo zgłoś się do Regionalnego Centrum Kriodawstwa i Krwiolecznictwa w dogodnym dla Ciebie momencie.</p>
                <p>Twoja krew stanowi niezwykle cenny surowiec, którego nie da się wytworzyć syntetycznie. To dlatego oddawanie krwi jest takie ważne!</p>
                <p>Dowiedz się więcej na stronie <a href="http://krwiodawstwo.pl/26/jak-zostac-krwiodawca">RCKiK w Łodzi</a>.</p>
            </div>
            <div class="col-md-4 col-xs-12">
                <h3>Szpik</h3>

                <p>Otrzymujesz także niepowtarzalną okazję zapisania się do bazy dawców szpiku. Wystarczy tylko, że wypełnisz formularz rejestracyjny na akcji Wampiriady i nic więcej nie musisz robić! Podczas badań pielęgniarka pobierze dodatkową próbkę krwi do badań, ale to żaden problem, skoro i tak oddajesz 450ml :)</p>
                <p>Po zapisaniu do bazy dawców szpiku otrzymujesz możliwość uratowania życia osoby chorej na białaczkę lub inne choroby krwi, ale tylko wtedy, kiedy jesteście zgodni ze sobą genetycznie. Zdarza się to bardzo rzadko - część dawców nigdy nie będzie oddawać szpiku innej osobie. Dlatego tak ważne jest, żeby jak najwięcej osób było w bazie dawców.</p>
                <p>Pamiętaj, zapisanie się do bazy szpiku jest niezobowiązujące. Decyzję o oddaniu szpiku podejmiesz dopiero wtedy, kiedy znajdzie się biorca pasujący do Ciebie.</p>
                <p>Dowiedz się więcej na stronie <a href="http://www.cskis.umed.pl/szpik/podstawowe-informacje/">Centralnego Szpitala Klinicznego Instytutu Stomatologii w Łodzi</a>.</p>
            </div>
        </div>
    </div>
</section>

@include('wampiriada.templates.index_display_results')

<div class="secondary">

<section class="second-background">
    <div class="przyjacielwampira">
        {!! $repository->getRedirectAsTag('facebook', '<img src="img/layout/przyjacielwampira.png" alt="Zostań przyjacielem Wampira">') !!}
    </div>
</section>

<section id="dontforget">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="clearfix">
                        <h2>To nie wszystko!</h2>
                        <p>Zobacz, co jeszcze dla Ciebie przygotowaliśmy.</p>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                    <h3>Gifty dla oddających</h3>
                    <div class="icon"><i class="fa fa-gift"></i></div>
                    <p>W zamian za oddanie krwi otrzymasz:</p>
                    <ul>
                        <li>osiem czekolad;</li>
                        <li>batonik i napój energetyczny;</li>
                        <li>{!! $repository->getRedirectAsTag('koszulka', 'koszulkę Wampira') !!};</li>
                        <li>studenckie zniżki;</li>
                        <li>możliwość wzięcia udziału w wampiriadowym konkursie;</li>
                        <li>nieopisaną satysfakcję z niesienia pomocy innym :)</li>
                    </ul>
            </div>
            <div class="col-md-8">
            <div class="row contest">
            <div class="col-md-6">
                <h3>Konkurs dla Krwiodawców</h3>
                <div class="icon"><i class="fa fa-tint"></i></div>
                <ol>
                    <li>oddaj krew,</li>
                    <li>polub {!! $repository->getRedirectAsTag('facebook-nzs', 'NZSRegionuŁódzkiego na Facebooku') !!},</li>
                    <li>udostępnij publicznie {!! $repository->getRedirectAsTag('plakat', 'plakat Wampiriady') !!} na swojej tablicy z hasztagiem {!! $repository->getRedirectAsTag('przyjacielwampira', '#przyjacielWAMPIRA') !!}.</li>
                </ol>
            </div>
            <div class="col-md-6">
                <h3>Selfie z Wampirem</h3>
                <div class="icon"><i class="fa fa-camera"></i></div>

                <ol>
                    <li>zrób sobie selfie z Wampirem;</li>
                    <li>polub {!! $repository->getRedirectAsTag('facebook-nzs', 'NZSRegionuŁódzkiego na Facebooku') !!},</li>
                    <li>opublikuj selfie na stronie {!! $repository->getRedirectAsTag('facebook', 'Wampiriady Niezależnego Zrzeszenia Studentów Regionu Łódzkiego') !!} z dopiskiem {!! $repository->getRedirectAsTag('przyjacielwampira', '#przyjacielWAMPIRA') !!}.</li>
                </ol>

            </div>
            <div class="col-md-12">
            <p>Za wygraną w konkursie otrzymasz nagrody w postaci kuponów na pizzę Fiero, biletów teatralnych, gadżetow Uniwersytetu Łódzkiego, Politechniki Łódzkiej, Uniwersytetu Medycznego w Łodzi, Regionalnego Centrum Krwiodawstwa i wiele innych.</p>

            <p>Więcej o konkursach na stronie {!! $event_redirect->asTag("oficjalnego eventu {$repository->getEditionNumber()}. edycji Wampiriady") !!}.</p>
            </div>
            </div>
            </div>
        </div>
    <div class="row padding-top">
        <div class="col-md-8">
            <div  data-width="500" class="fb-page" data-href="https://www.facebook.com/wampiriada.nzs.rl" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/wampiriada.nzs.rl"><a href="https://www.facebook.com/wampiriada.nzs.rl">Wampiriada NZS RŁ</a></blockquote></div></div>


        </div>
        <div class="col-md-4">
                <div class="row mobile">
                    <div class="col-xs-8 col-md-12">
                        <h3>Aplikacja mobilna Wampiriady</h3>
                        <p>Pobierz aplikację mobilną Wampiriady na system Android i&nbsp;otrzymuj informacje o bieżących akcjach Wampiriady.</p>
                        <p class="appstore">
                        <a href="https://play.google.com/store/apps/details?id=pl.makimo.wampiriada">
                            <img alt="Pobierz z Google Play" src="{{ url('img/google-play.png') }}" />
                        </a>
                        </p>
                    </div>
                    <div class="col-xs-4 col-md-12">
                        <p>
                            <img class="like-h3" src="{{ url('img/wampiriada-market.png') }}" alt="Kod QR aplikacji mobilnej Wampiriady" >
                        </p>
                    </div>
                </div>
        </div>
    </div>
    </div>
</section>

@if($repository->getGalleryActions()->count())
<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="clearfix">
                    <h2>Galeria</h2>
                    <p>Zobacz, co się działo na akcjach Wampiriady!</p>
                </div>
            </div>
        </div>

        @foreach($repository->getGalleryActions() as $index => $action)
        <div class="row">
            <div class="col-md-8 col-md-push-{{ ($index % 2) ? 0 : 4 }} gallery-image-container">
                <a href="{{ $action->gallery_link }}"><img class="gallery-image" src="{{ url($action->gallery_image) }}" alt="{{ $action->place }}"></a>
            </div>
            <div class="col-md-4 col-md-pull-{{ ($index % 2) ? 0 : 8 }} gallery-image-description">
                <h3>{{ $action->day->format('d/m') }}</h3>
                <p class="place">{{ $action->place }}</p>
                <p>{{ $action->school }}, {{ $action->address }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<section class="contact">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="clearfix">
                    <h2>Kontakt i przydatne linki</h2>
                    <p>Chcesz wiedzieć więcej? Zajrzyj tutaj:</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 ">
            <div class="bigga">
                <nav>

                <ul>
                @if($event_redirect->exists())
                <li><a href="{{ $event_redirect }}">oficjalny event {{ $repository->getEditionNumber() }}. edycji Wampiriady</a></li>
                @endif
                <li><a href="{{ $repository->getRedirect('facebook') }}">facebook.com/&shy;wampiriada.nzs.rl</a></li>
                <li><a href="{{ $repository->getRedirect('nzs') }}">Organizator - NZS Regionu Łódzkiego</a></li>
                <li><a href="{{ $repository->getRedirect('facebook-nzs') }}">facebook.com/&shy;NZSRegionuLodzkiego</a></li>
                <li><a href="{{ $repository->getRedirect('twitter-nzs') }}">@nzslodz - nasz twitter</a></li>
                <li><a href="mailto:nzs@nzs.lodz.pl">Masz pytanie? Napisz do nas: nzs@nzs.lodz.pl</a></li>
                </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="who">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="clearfix">
                        <h2>Organizator</h2>
                        <p>Zajrzyj na naszą stronę, jeśli podoba Ci się to, co robimy.</p>
                </div>
            </div>
        </div>

            <div class="row top-27">
                <div class="col-xs-push-3 col-xs-6 col-md-4 col-md-push-4">
                    <a href="{{ $repository->getRedirect('nzs') }}"><img src="{{ url('img/nzs.png') }}" alt="Niezależne Zrzeszenie Studentów Regionu Łódzkiego"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center cooperation">
                    <p>Przy współpracy z:</p>
                </div>

                <div class="col-xs-6 col-md-4 col-md-push-2">
                    <a href="http://krwiodawstwo.pl"><img src="{{ url('img/rck.png') }}" alt="Regionalne Centrum Krwiodawstwa i Krwiolecznictwa w Łodzi"></a>
                </div>
                <div class="col-xs-6 col-md-4 col-md-push-2">
                    <a href="http://www.cskis.umed.pl/szpik/"><img src="{{ url('img/csk.png') }}" alt="Centralny Szpital Kliniczny Instytut Stomatologii Uniwersytetu Medycznego w Łodzi"></a>
                </div>
            </div>
    </div>

</section>

<section id="partners">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="clearfix">
                    <h2>Partnerzy</h2>
                    <p>Serdecznie dziękujemy naszym partnerom za możliwość przeprowadzenia akcji Wampiriada w Łodzi.</p>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="logo-container col-xs-12">
                @foreach ($partners as $row)
                    <div class="flex-row row-{{ $row->getCount() }}">
                        @foreach($row->getPartners() as $item)

                        <div class="flex-item">
                            @if($item->url)
                                <a href="{{ $item->url }}" target="_blank">
                            @endif
                            @if($item->image)
                                <p class="image"><img src="{{ $item->image }}" alt="{{ $item->title }}">
                            @else
                                <p class="noimage">{{ $item->title }}</p>
                            @endif
                            @if($item->url)
                                </a>
                            @endif
                        </div>

                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <a class="button" href="#intro"><i class="fa fa-arrow-up"></i> Powrót na górę</a>
</section>
</div>

<script id="map-item-template" type="text/x-handlebars-template">
    <p class="action-date"><strong>@{{day}} (@{{time}})</strong></p>
    <h3>@{{title}}</h3>
    <p class="school-address">@{{address}}</p>
</script>

@stop
