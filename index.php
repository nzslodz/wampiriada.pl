<?php namespace Silverplate; 

use NZS\Application\Controller;
use NZS\Core\Exceptions\ObjectDoesNotExist;

meta('title', 'Wampiriada w Łodzi');
meta('description', 'Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.');

$controller = new Controller;

$repository = $controller->getEdition(27);

$event_redirect = $repository->getRedirect("facebook-event");

$display_results = true;
$display_actions = true;

try {
    $results = $repository->getResults();
} catch(ObjectDoesNotExist $e) {
    $display_results = false;
}

try {
    $last_year_edition = $controller->getEdition($repository->getEdition() - 2);
    $overall_difference = $repository->getOverallDifference($last_year_edition) * 0.45;
} catch(ObjectDoesNotExist $e) {
    $overall_difference = false;
}

try {
    $actions = $repository->getActions();
} catch(ObjectDoesNotExist $e) {
    $display_actions = false;
}

function oddalo($num) {
    $mod_100 = $num % 100;
    $mod_10 = $num % 10;
    if($mod_100 > 10 && $mod_100 < 20) {
        return 'osób oddało';
    }

    if($mod_10 > 1 && $mod_10 < 5) {
        return 'osoby oddały';
    }

    return 'osób oddało';
}

?>

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

<?php if($display_actions): ?>
<section id="schedule">
<div class="container">
   <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>Terminy <?php echo $repository->getEdition() ?>. edycji Wampiriady</h2>
                    <p class="date">11.2015 r. - 12.2015 r.</p>
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

                <?php foreach($actions as $action): ?>
                <li class="row <?php echo $controller->getClass($action->school_short) ?>" data-lat="<?php echo $action->lat ?>" data-lng="<?php echo $action->lng ?>">
                    <p class="col-xs-2 date"><span><?php echo date('d/m', strtotime($action->day)) ?></span></p>
                    <p class="col-xs-5 place <?php echo $controller->getClass($action->school_short) ?>" data-sort="<?php echo $action->school_short ?>" data-address="<?php echo $action->address ?>"><?php echo $action->place ?></p>
                    <p class="col-xs-2 time"><?php echo date('H', strtotime($action->start)) ?> - <?php echo date('H', strtotime($action->end)) ?></p>
                    <p class="col-xs-2 marrow text-center"><?php if($action->marrow): ?><i class="fa fa-check"></i><?php endif; ?></p>
                </li>
                <?php endforeach; ?>
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
<?php else: ?>
<section id="coming-soon">
<div class="container">
   <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2><?php echo $repository->getEdition() ?>. edycja Wampiriady</h2>
                    <p class="not-found">Już wkrótce pełny grafik terminów akcji Wampiriady.<br>Zapraszamy niebawem!</p>
                </header>
            </div>
        </div>
    </div>
</div>
</section>
<?php endif; ?>

<section class="description <?php if($display_results): ?>with-results<?php endif; ?>">
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
                <img class="fancyphoto" src="<?php echo App::path('img/oddaj.jpg') ?>" alt="Pół litra oddajesz, Wampirem się stajesz">
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

<?php if($display_results): ?>
<section id="results">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>Wyniki <?php echo $repository->getEdition() ?>. edycji Wampiriady</h2>
                    <p class="date">11.2015 r. - 12.2015 r.</p>
                </header>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="overall <?php if($results->overall > 1000): ?>smallfont<?php endif; ?>">
                <div class="big"><?php echo $results->overall ?></div> 
                <div class="small"><?php echo oddalo($results->overall) ?> krew</div>

                <div class="note"><?php echo $results->overall * 0.45 ?></div>
                <div class="foot">litrów krwi</div>
            </div>
        </div>
        <div class="col-md-8">
                <div id="magicalchart" class="row" style="height: 460px"
                    data-zero-minus="<?php echo $results->zero_minus ?>"
                    data-zero-plus="<?php echo $results->zero_plus ?>"
                    data-a-minus="<?php echo $results->a_minus ?>"
                    data-a-plus="<?php echo $results->a_plus ?>"
                    data-b-minus="<?php echo $results->b_minus ?>"
                    data-b-plus="<?php echo $results->b_plus ?>"
                    data-ab-plus="<?php echo $results->ab_plus ?>"
                    data-ab-minus="<?php echo $results->ab_minus ?>"   
                    data-unknown="<?php echo $results->unknown ?>"
                ></div>
        </div>
    <!--    
    <div class="row thanks">
        <p>
            Wampiriada zakończona! Wedle oficjalnych informacji z Regionalnego Centrum Krwiodawstwa, udało się zebrać aż <?php echo $results->overall * 0.45 ?> litrów krwi<?= $overall_difference ? ",": "." ?>
            <?php if($overall_difference): ?>
                czyli <strong>o <?php echo $overall_difference ?> litra więcej niż na ostatniej</strong> jesiennej Wampiriadzie.
            <?php endif; ?>
        </p>
        <p class="itsbig">Dziękujemy serdecznie,</p>
        <p class="center">ponieważ wspólnie udało się nam osiągnąć coś wielkiego.</p>
        <p>Zapraszamy na kolejną Wampiriadę, która odbędzie się w maju 2014 r., oraz do pobierania naszej aplikacji na Androida.</p>
    </div>
    </div>
    -->
    </div>
    </div>
</section>
<?php endif; ?>

<div class="secondary">

<section class="second-background">
    <div class="przyjacielwampira">
        <?php echo $repository->getRedirectAsTag('facebook', '<img src="img/layout/przyjacielwampira.png" alt="Zostań przyjacielem Wampira">') ?>
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
                        <li><?php echo $repository->getRedirectAsTag('koszulka', 'koszulkę Wampira') ?>;</li>
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
                    <li>polub <?php echo $repository->getRedirectAsTag('facebook-nzs', 'NZSRegionuŁódzkiego na Facebooku') ?>,</li>
                    <li>udostępnij publicznie <?php echo $repository->getRedirectAsTag('plakat', 'plakat Wampiriady') ?> na swojej tablicy z hasztagiem <?php echo $repository->getRedirectAsTag('przyjacielwampira', '#przyjacielWAMPIRA') ?>.</li>
                </ol>
            </div>
            <div class="col-md-6">
                <h3>Selfie z Wampirem</h3>
                <div class="icon"><i class="fa fa-camera"></i></div>

                <ol>
                    <li>zrób sobie selfie z Wampirem;</li>
                    <li>polub <?php echo $repository->getRedirectAsTag('facebook-nzs', 'NZSRegionuŁódzkiego na Facebooku') ?>,</li>
                    <li>opublikuj selfie na stronie <?php echo $repository->getRedirectAsTag('facebook', 'Wampiriady Niezależnego Zrzeszenia Studentów Regionu Łódzkiego') ?> z dopiskiem <?php echo $repository->getRedirectAsTag('przyjacielwampira', '#przyjacielWAMPIRA') ?>.</li>
                </ol>

            </div>
            <div class="col-md-12">
            <p>Za wygraną w konkursie otrzymasz nagrody w postaci kuponów na pizzę Fiero, biletów teatralnych, gadżetow Uniwersytetu Łódzkiego, Politechniki Łódzkiej, Uniwersytetu Medycznego w Łodzi, Regionalnego Centrum Krwiodawstwa i wiele innych.</p>

            <p>Więcej o konkursach na stronie <?php echo $event_redirect->asTag("oficjalnego eventu {$repository->getEdition()}. edycji Wampiriady") ?>.</p>
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
                            <img alt="Pobierz z Google Play" src="https://developer.android.com/images/brand/pl_generic_rgb_wo_60.png" />
                        </a>
                        </p>
                    </div>
                    <div class="col-xs-4 col-md-12">
                        <p>
                            <img class="like-h3" src="<?php echo App::path('img/wampiriada-market.png'); ?>" alt="Kod QR aplikacji mobilnej Wampiriady" >
                        </p>
                    </div>
                </div>
        </div>
    </div>
    </div>
</section>

<?php if($repository->getGalleryActions()->count()): ?>
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

        <?php foreach($repository->getGalleryActions() as $index => $action): ?>
        <div class="row">
            <div class="col-md-8 col-md-push-<?php echo ($index % 2) ? 0 : 4 ?> gallery-image-container">
                <a href="<?php echo $action->gallery_link ?>"><img class="gallery-image" src="<?php echo App::path($action->gallery_image) ?>" alt="<?php echo $action->place ?>"></a>
            </div>
            <div class="col-md-4 col-md-pull-<?php echo ($index % 2) ? 0 : 8 ?> gallery-image-description">
                <h3><?php echo date('d/m', strtotime($action->day)) ?></h3>
                <p class="place"><?php echo $action->place ?></p>
                <p><?php echo $action->school ?>, <?php echo $action->address ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

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
                <?php $event_redirect->open() ?>
                <li><a href="<?php echo $event_redirect ?>">oficjalny event <?php echo $repository->getEdition() ?>. edycji Wampiriady</a></li>
                <?php $event_redirect->close() ?>
                <li><a href="<?php echo $repository->getRedirect('facebook') ?>">facebook.com/&shy;wampiriada.nzs.rl</a></li>
                <li><a href="<?php echo $repository->getRedirect('nzs') ?>">Organizator - NZS Regionu Łódzkiego</a></li>
                <li><a href="<?php echo $repository->getRedirect('facebook-nzs') ?>">facebook.com/&shy;NZSRegionuLodzkiego</a></li>
                <li><a href="<?php echo $repository->getRedirect('twitter-nzs') ?>">@nzslodz - nasz twitter</a></li>
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
                    <a href="<?php echo $repository->getRedirect('nzs') ?>"><img src="<?php echo App::path('img/nzs.png') ?>" alt="Niezależne Zrzeszenie Studentów Regionu Łódzkiego"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center cooperation">
                    <p>Przy współpracy z:</p>
                </div>

                <div class="col-xs-6 col-md-4 col-md-push-2">
                    <a href="http://krwiodawstwo.pl"><img src="<?php echo App::path('img/rck.png') ?>" alt="Regionalne Centrum Krwiodawstwa i Krwiolecznictwa w Łodzi"></a>
                </div>
                <div class="col-xs-6 col-md-4 col-md-push-2">
                    <a href="http://www.cskis.umed.pl/szpik/"><img src="<?php echo App::path('img/csk.png') ?>" alt="Centralny Szpital Kliniczny Instytut Stomatologii Uniwersytetu Medycznego w Łodzi"></a>
                </div>
            </div>
    </div>

</section>

<?php

$partners = [
    'uml-main' => [
        'title' => 'Urząd Miasta Łodzi',
        'link' => 'http://uml.lodz.pl',
        'image' => 'img/partnerzy/01.jpg',
    ],
    'wl-main' => [
        'title' => 'Urząd Wojewódzki w Łodzi',
        'link' => 'http://lodzkie.pl',
        'image' => 'img/partnerzy/02.jpg',
    ],
    'uml-zdrowie' => [
        'title' => 'Wydział Zdrowia Urzędu Miasta Łodzi',
        'link' => 'http://uml.lodz.pl',
        'image' => 'img/partnerzy/03.jpg',
    ],
    'wl-lodzkie' => [
        'title' => 'Promuje Łódzkie',
        'link' => 'http://lodzkie.pl',
        'image' => 'img/partnerzy/04.jpg',
    ],
    'pzu' => [
        'title' => 'Grupa PZU',
        'link' => 'http://pzu.pl',
        'image' => 'img/partnerzy/05.jpg',
    ],
    'fitfabric' => [
        'title' => 'FitFabric',
        'link' => 'http://fitfabric.pl',
        'image' => 'img/partnerzy/06.jpg',
    ],

    'ul' => [
        'title' => 'Uniwersytet Łódzki',
        'link' => 'http://uni.lodz.pl',
        'image' => 'img/partnerzy/07.jpg',
    ],
    'pl' => [
        'title' => 'Politechnika Łódzka',
        'link' => 'http://p.lodz.pl',
        'image' => 'img/partnerzy/08.jpg',
    ],
    'um' => [
        'title' => 'Uniwersytet Medyczny w Łodzi',
        'link' => 'http://umed.pl',
        'image' => 'img/partnerzy/09.jpg',
    ],
    'wsiu' => [
        'title' => 'Wyższa Szkoła Informatyki i Umiejętności w Łodzi',
        'link' => 'http://wsinf.edu.pl',
        'image' => 'img/partnerzy/13.jpg',
    ],
    'szuster' => [
        'title' => 'Szkoła Języków Obcych Szuster',
        'link' => 'http://www.studium.com.pl',
        'image' => 'img/partnerzy/18.jpg',
    ],
    'fiero' => [
        'title' => 'Pizzeria Fiero!',
        'link' => 'http://fieropizza.pl',
        'image' => 'img/partnerzy/14.jpg',
    ],
    'makimo' => [
        'title' => 'Makimo Sp. z o.o.',
        'link' => 'http://makimo.pl',
        'image' => 'img/partnerzy/19.jpg',
    ],
    'happylodz' => [
        'title' => 'HappyLodz',
        'link' => 'https://www.facebook.com/HappyLodz',
        'image' => 'img/partnerzy/happylodz.png',
    ],

    'plaster' => [
        'title' => 'Plaster Łódzki',
        'link' => 'http://plasterlodzki.pl',
        'image' => 'img/partnerzy/25.jpg',
    ],
    
    'dlastudenta' => [
        'title' => 'dlastudenta.pl',
        'link' => 'http://dlastudenta.pl',
        'image' => 'img/partnerzy/27.jpg',
    ],

    'infostudent' => [
        'title' => 'InfoStudent',
        'link' => 'http://www.infosgroup.pl/infostudent/',
        'image' => 'img/partnerzy/26.jpg',
    ],

    'studentnews' => [
        'title' => 'studentnews.pl',
        'link' => 'http://studentnews.pl',
        'image' => 'img/partnerzy/28.jpg',
    ],

    'zak' => [
        'title' => 'Studenckie Radio Żak',
        'link' => 'http://www.zak.lodz.pl',
        'image' => 'img/partnerzy/23.jpg',
    ],

    'studentlodz' => [
        'title' => 'Portal student.lodz.pl',
        'link' => 'http://student.lodz.pl',
        'image' => 'img/partnerzy/29.jpg',
    ],
    
    'eska' => [
        'title' => 'Radio Eska',
        'link' => 'http://eska.pl',
        'image' => 'img/partnerzy/21.jpg',
    ],

    'asp' => [
        'title' => 'Akademia Sztuk Pięknych im. Władysława Strzemińskiego w Łodzi',
        'link' => 'https://www.asp.lodz.pl',
        'image' => 'img/partnerzy/asp.jpg',
    ],

    'teatr-nowy' => [
        'title' => 'Teatr Nowy im. Kazimierza Dejmka w Łodzi',
        'link' => 'http://www.nowy.pl',
        'image' => 'img/partnerzy/nowy.jpg',
    ],

    'teatr-wielki' => [
        'title' => 'Teatr Wielki w Łodzi',
        'link' => 'http://operalodz.com',
        'image' => 'img/partnerzy/wielki.jpg',
    ],

];

$structure = [
    [ 'uml-main', 'wl-main', 'uml-zdrowie', 'wl-lodzkie', ],
    [ 'ul', 'pl', 'um', 'asp', 'wsiu' ],
    [ 'pzu', 'fiero', 'teatr-wielki', 'teatr-nowy' ],
    [ 'makimo', 'eska', 'plaster', 'dlastudenta'],
    [ 'infostudent', 'zak', 'studentnews', 'studentlodz'],
];

$unknown = [
    'title' => 'Does not Exist: Key <strong>%s</strong> in partner store.',
];

?>

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
                <?php foreach ($structure as $row):
                    $count = count($row); 
                ?>
                    <div class="flex-row row-<?php echo $count ?>">
                        <?php foreach($row as $key):
                           
                                if(isset($partners[$key])) {
                                    $item = $partners[$key];
                                } else {
                                    $item = $unknown;
                                }

                            $title = str_replace('%s', $key, $item['title']);

                        ?>

                        <div class="flex-item">
                            <?php if(isset($item['link'])): ?>
                                <a href="<?php echo $item['link'] ?>" target="_blank">
                            <?php endif; ?>
                            <?php if(isset($item['image'])): ?>
                                <p class="image"><img src="<?php echo $item['image'] ?>" alt="<?php echo $title ?>">
                            <?php else: ?>
                                <p class="noimage"><?php echo $title ?></p>
                            <?php endif; ?>
                            <?php if(isset($item['link'])): ?>
                                </a>
                            <?php endif; ?>
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
    <p class="action-date"><strong>{{day}} ({{time}})</strong></p>
    <h3>{{title}}</h3>
    <p class="school-address">{{address}}</p>
</script>
