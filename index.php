<?php namespace Silverplate; ?>
<?php meta('title', 'Wampiriada w Łodzi') ?>
<?php meta('description', 'Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.') ?>

<?php

include __DIR__ . '/lib/wamp.php'; 

$wamp = new \Wamp(23);
$data = $wamp->getData();

extract($data);

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
    <div class="grid">
        <div class="row center">
                <h1><img src="<?php echo App::path('img/wampir-logo.png') ?>" alt="Wampiriada - studenckie honorowe krwiodawstwo"></h1>
        </div>

        <div class="row mobile">
            <div class="slot-0-1-2-3">
                <h3>Aplikacja mobilna Wampiriady</h3>
                <p>Pobierz aplikację mobilną Wampiriady na system Android i&nbsp;otrzymuj informacje o bieżących akcjach i&nbsp;osobach, które potrzebują krwi.</p>
                <a href="https://play.google.com/store/apps/details?id=pl.makimo.wampiriada">
                  <img alt="Pobierz z Google Play"
                         src="https://developer.android.com/images/brand/pl_generic_rgb_wo_60.png" />
                         </a>
            </div>
            <div class="slot-4-5">
                <img class="like-h3" src="<?php echo App::path('img/wampiriada-market.png'); ?>" alt="Kod QR aplikacji mobilnej Wampiriady" >
            </div>

            <div class="clearfix"></div>
        </div>

        <!--<header class="row">
            <h2>Wyniki 22. edycji Wampiriady</h2>
            <p class="date">05.2013 r. - 06.2013 r.</p>
        </header>
        <div class="row">
            <div class="slot-0-1 overall <?php if($overall > 1000): ?>smallfont<?php endif; ?>">
                <div class="big"><?php echo $overall ?></div> 
                <div class="small"><?php echo oddalo($overall) ?> krew</div>

                <div class="note"><?php echo $overall * 0.45 ?></div>
                <div class="foot">litrów krwi</div>
            </div>
            <div class="slot-2-3-4-5">
                <div id="magicalchart" class="row" style="height: 460px"
                    data-zero-minus="<?php echo $zero_minus ?>"
            data-zero-plus="<?php echo $zero_plus ?>"
            data-a-minus="<?php echo $a_minus ?>"
            data-a-plus="<?php echo $a_plus ?>"
            data-b-minus="<?php echo $b_minus ?>"
            data-b-plus="<?php echo $b_plus ?>"
            data-ab-plus="<?php echo $ab_plus ?>"
            data-ab-minus="<?php echo $ab_minus ?>"   
            data-unknown="<?php echo $unknown ?>"
        ></div>
            </div>
        </div>
    <div class="row thanks">
        <p>Wampiriada zakończona! Wedle oficjalnych informacji z Regionalnego Centrum Krwiodawstwa, udało się zebrać aż <?php echo $overall * 0.45 ?> litrów krwi, czyli <strong>o 11.7 litra więcej niż na ostatniej</strong> wiosennej Wampiriadzie.</p>
        <p class="itsbig">Dziękujemy serdecznie,</p>
        <p class="center">ponieważ bez Was by się to nie udało.</p>
        <p>Zapraszamy na jesienną Wampiriadę, która odbędzie się w listopadzie, oraz do pobierania naszej aplikacji na Androida.</p>
    </div>
    </div>-->

    
    <a class="button" href="#schedule"><i class="icon-arrow-down"></i> Terminy akcji</a>
</section>

<section id="schedule">
    <div class="grid">
        <div class="row">
            <header>
                <h2>Terminy 23. akcji Wampiriady</h2>
                <p class="date">11.2013 r. - 12.2013 r.</p>
            </header>

            <div class="sorting">
                <span>Sortowanie:</span>
                <a href="#" class="active" data-option-value="original-order"><i class="icon-time"></i> Chronologiczne</a>
                <a href="#" data-option-value="name"><i class="icon-map-marker"></i> Po uczelniach</a>
            </div>

                <div class="row legend">
                    <p class="slot-0 date">Dzień</p>
                    <p class="slot-1-2-3 place" data-sort="PŁ">Miejsce trwania akcji</p>
                    <p class="slot-4 time">Czas akcji</p>
                    <p class="slot-5 marrow">Szpik</p>
                </div>
            <ul class="isotope">
                <?php foreach($wamp->getActions() as $action): ?>
                <li class="row <?php echo $wamp->getClass($action->school_short) ?>">
                    <p class="slot-0 date"><?php echo date('d.m', strtotime($action->day)) ?></p>
                    <p class="slot-1-2-3 place <?php echo $wamp->getClass($action->school_short) ?>" data-sort="<?php echo $action->school_short ?>"><?php echo $action->place ?></p>
                    <p class="slot-4 time"><?php echo date('H', strtotime($action->start)) ?> - <?php echo date('H', strtotime($action->end)) ?></p>
                    <p class="slot-5 marrow"><?php if($action->marrow): ?><i class="icon-ok"></i> szpik<?php endif; ?></p>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>

    <a class="button" href="#dontforget"><i class="icon-arrow-down"></i> Czas na fun</a>
    <!--<a class="button" href="#who"><i class="icon-arrow-down"></i> Kto za tym stoi?</a>-->
</section>

<section id="dontforget">
    <div class="grid">
            <header>
                <h2>To nie wszystko!</h2>
                <p>Zobacz, co jeszcze dla Ciebie przygotowaliśmy.</p>
            </header>

            <div class="row">
                <div class="slot-0-1-2">
                    <!--<p class="center"><img src="<?php echo App::path('img/wampir.png') ?>" alt=""></p>-->
                    <h3>Gifty</h3>
                    <p>W zamian za oddanie krwi otrzymasz:</p>
                    <ul>
                        <li>osiem czekolad;</li>
                        <li>batonik i napój energetyczny;</li>
                        <li>koszulkę Wampira;</li>
                        <li>nieopisaną satysfakcję z niesienia pomocy innym :)</li>
                        <li>oraz zaproszenie na WAMPIRPARTY.</li>
                    </ul>
                </div>
                <div class="slot-3-4-5">
                    <h3>Pozostań w kontakcie</h3>
                    <p>Najświeższe informacje o naszych projektach możesz zdobyć tutaj:</p>
                    <ul>
                        <li><a href="https://nzs.lodz.pl">NZS Regionu Łódzkiego</a></li>
                        <li><a href="https://wampiriada.pl">Strona Wampiriady</a></li>
                        <li><a href="https://www.facebook.com/wampiriada.nzs.rl">Wampiriada NZS RŁ</a></li>
                        <li><a href="https://www.facebook.com/events/767672216583546/">Oficjalny event 23. edycji Wampiriady</a></li>
                    </ul>
                </div>
                <!--<div class="slot-3-4-5">
                    <p class="lordis center"><img src="<?php echo App::path('img/lordis.png') ?>" alt="Logo Lordi's Club"></p>
                    <h3>Impreza</h3>
                    <p>Już 30 maja w Lordi's Club przy ul. Piotrkowskiej 102 rozlegną się dźwięki WAMPIRPARTY, imprezy kierowanej do wszystkich honorowych krwiodawców, którzy oddali swoją krew podczas tej edycji Wampiriady. Przyjdź i weź ze sobą znajomych.</p>
                </div>-->
            </div>

            <div class="row">
                <!--<div class="slot-0-1-2">
                    <h3>Polub nas na Facebooku,</h3>
                    <p>a weźmiesz udział w losowaniu nagród takich jak karnety do Fitfabric Fitness Club, kursów językowych Profilingua, czy darmowych kuponów na pizzę w pizzerii Fiero. Losowanie odbywa się po każdej akcji Wampiriady!</p>
                    <p>Nasz fanpage: <a href="https://www.facebook.com/NZSRegionuLodzkiego">NZS Regionu Łódzkiego</a>.</p>
                </div>-->
            </div>
    </div>
    <a class="button" href="#who"><i class="icon-arrow-down"></i> Kto za tym stoi?</a>
</section>

<section id="who">
    <div class="grid">
            <header>
                <h2>Organizatorzy</h2>
                <p>Zajrzyj na nasze strony, jeśli podoba Ci się nasza akcja.</p>
            </header>

            <div class="row">
            <div class="slot-0-1-2">
                <a href="http://nzs.lodz.pl"><img src="<?php echo App::path('img/nzs.png') ?>" alt="Niezależne Zrzeszenie Studentów Regionu Łódzkiego"></a>
            </div>
            <div class="slot-3-4-5">
                <a href="http://krwiodawstwo.pl"><img src="<?php echo App::path('img/rck.png') ?>" alt="Regionalne Centrum Krwiodawstwa i Krwiolecznictwa w Łodzi"></a>
            </div>
            </div>
    </div>

    <a class="button" href="#partners"><i class="icon-arrow-down"></i> Nasi partnerzy</a>
</section>
<section id="partners">
    <div class="grid">
            <header>
                <h2>Partnerzy</h2>
                <p>Serdecznie dziękujemy naszym partnerom za możliwość przeprowadzenia akcji Wampiriada w Łodzi.</p>
            </header>
           
            <div style="height: 530px">
            </div>

            <div class="row">
                <img src="<?php echo App::path('img/logotypyweb.png') ?>" alt="Logotypy naszych partnerów">
            </div>
    </div>
    <a class="button" href="#intro"><i class="icon-arrow-up"></i> Powrót na górę</a>
</section>
