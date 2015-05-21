<?php namespace Silverplate; 

use NZS\Wampiriada\Controller;
use NZS\Wampiriada\ObjectDoesNotExist;

meta('title', 'Wampiriada w Łodzi');
meta('description', 'Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.');

$controller = new Controller;

$repository = $controller->getEdition(26);

$display_results = true;

try {
    $results = $repository->getResults();
} catch(ObjectDoesNotExist $e) {
    $display_results = false;
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


<section id="schedule">
<div class="container">
   <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>Terminy 26. akcji Wampiriady</h2>
                    <p class="date">05.2015 r. - 06.2015 r.</p>
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

                <?php foreach($repository->getActions() as $action): ?>
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
                    <h2>Wyniki 26. edycji Wampiriady</h2>
                    <p class="date">05.2015 r. - 06.2015 r.</p>
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
        <p>Wampiriada zakończona! Wedle oficjalnych informacji z Regionalnego Centrum Krwiodawstwa, udało się zebrać aż <?php echo $results->overall * 0.45 ?> litrów krwi, czyli <strong>o <?php echo $repository->getOverallDifference($controller->getEdition($repository->getEdition() - 2)) * 0.45 ?> litra więcej niż na ostatniej</strong> jesiennej Wampiriadzie.</p>
        <p class="itsbig">Dziękujemy serdecznie,</p>
        <p class="center">ponieważ wspólnie udało się nam osiągnąć coś wielkiego.</p>
        <p>Zapraszamy na wiosenną Wampiriadę, która odbędzie się w maju 2014 r., oraz do pobierania naszej aplikacji na Androida.</p>
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
        <a href="https://www.facebook.com/wampiriada.nzs.rl"><img src="img/layout/przyjacielwampira.png" alt="Zostań przyjacielem Wampira"></a>
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
                        <li><a href="https://www.facebook.com/wampiriada.nzs.rl/photos/a.119841281459933.20746.110146435762751/765979013512820/?type=1&theater">koszulkę Wampira</a>;</li>
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
                    <li>polub <a href="https://facebook.com/NZSRegionuLodzkiego">NZSRegionuŁódzkiego na Facebooku</a>,</li>
                    <li>udostępnij publicznie <a href="https://www.facebook.com/NZSRegionuLodzkiego/photos/a.165034606884513.46602.150737411647566/842944849093482/?type=1&theater">plakat Wampiriady</a> na swojej tablicy z hasztagiem <a href="https://www.facebook.com/hashtag/przyjacielwampira">#przyjacielWAMPIRA</a>,</li>
                </ol>
            </div>
            <div class="col-md-6">
                <h3>Selfie z Wampirem</h3>
                <div class="icon"><i class="fa fa-camera"></i></div>

                <ol>
                    <li>zrób sobie selfie z Wampirem;</li>
                    <li>polub <a href="https://facebook.com/NZSRegionuLodzkiego">NZSRegionuŁódzkiego na Facebooku</a>,</li>
                    <li>opublikuj selfie na stronie <a href="http://www.facebook.com/wampiriada.nzs.rl">Wampiriady Niezależnego Zrzeszenia Studentów Regionu Łódzkiego</a> z dopiskiem <a href="https://www.facebook.com/hashtag/przyjacielwampira">#przyjacielWAMPIRA</a>,</li>
                </ol>

            </div>
            <div class="col-md-12">
            <p>Za wygraną w konkursie otrzymasz nagrody w postaci kursów językowych Szuster, kuponów na pizzę Fiero, gadżetow Uniwersytetu Łódzkiego, Politechniki Łódzkiej, Regionalnego Centrum Krwiodawstwa i wiele innych.</p>
            <p>Więcej o konkursach na stronie <a href="https://www.facebook.com/events/959790614053679/">oficjalnego eventu 26. edycji Wampiriady</a>.</p>
            </div>
            </div>


            </div>
        </div>
    <div class="row padding-top">
        <div class="col-md-8">
            <div class="bigga">
                <h3>Kontakt</h3>
                <nav>

                <ul>
                <li><a href="https://www.facebook.com/events/959790614053679/">oficjalny event 26. edycji Wampiriady</a></li>
                <li><a href="https://facebook.com/wampiriada.nzs.rl">facebook.com/&shy;wampiriada.nzs.rl</a></li>
                <li><a href="https://facebook.com/NZSRegionuLodzkiego">facebook.com/&shy;NZSRegionuLodzkiego</a></li>
                <li><a href="http://nzs.lodz.pl">nzs.lodz.pl - organizator</a></li>
                <li><a href="https://twitter.com/nzslodz">@nzslodz - nasz twitter</a></li>
                <li><a href="mailto:nzs@nzs.lodz.pl">Masz pytanie? Napisz do nas: nzs@nzs.lodz.pl</a></li>
                </nav>
            </div>
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
                    <a href="http://nzs.lodz.pl"><img src="<?php echo App::path('img/nzs.png') ?>" alt="Niezależne Zrzeszenie Studentów Regionu Łódzkiego"></a>
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

<!--<section id="partners">
    <div class="grid">
            <header>
                <h2>Partnerzy</h2>
                <p>Serdecznie dziękujemy naszym partnerom za możliwość przeprowadzenia akcji Wampiriada w Łodzi.</p>
            </header>
           
            <div style="height: 1900px"></div>

            <div class="row mojrow">
				<div style="">
					<a href="http://www.uml.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/01.jpg') ?>" /></a>
					<a href="http://www.lodzkie.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/02.jpg') ?>" /></a>
					<a href="http://www.uml.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/03.jpg') ?>" /></a>
					<a href="http://www.lodzkie.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/04.jpg') ?>" /></a>
				</div>
				<div style="">
					<a href="http://www.pzu.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/05.jpg') ?>" /></a>
					<a href="http://www.fitfabric.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/06.jpg') ?>" /></a>
				</div>
				<div style="">
					<a href="http://www.uni.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/07.jpg') ?>" /></a>
					<a href="http://www.amuz.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/12.jpg') ?>" /></a>
					<a href="http://www.p.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/08.jpg') ?>" /></a>
				</div>
				<div style="">
					<a href="http://wsinf.edu.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/13.jpg') ?>" /></a>
					<a href="http://www.umed.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/09.jpg') ?>" /></a>
					<a href="http://www.csk.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/10.jpg') ?>" /></a>
				</div>
				<div style="">
					<a href="http://fieropizza.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/14.jpg') ?>" /></a>
					<a href="http://www.charlie.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/16.jpg') ?>" /></a>
					<a href="http://www.nowy.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/15.jpg') ?>" /></a>
				</div>
				<div>
					<a href="http://www.studium.com.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/18.jpg') ?>" /></a>
					<a href="http://projectsalsa.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/17.jpg') ?>" /></a>
					<a href="http://makimo.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/19.jpg') ?>" /></a>
				</div>
				<div style="">
					<a href="http://www.tvp.pl/lodz" target="_blank"><img src="<?php echo App::path('img/partnerzy/20.jpg') ?>" /></a>
					<a href="http://www.eska.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/21.jpg') ?>" /></a>
					<a href="http://www.parada.fm/" target="_blank"><img src="<?php echo App::path('img/partnerzy/22.jpg') ?>" /></a>
				</div>
				<div>
					<a href="http://www.zak.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/23.jpg') ?>" /></a>
					<a href="http://radioul.uni.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/24.jpg') ?>" /></a>
				</div>
				<div style="">
					<a href="http://www.plasterlodzki.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/25.jpg') ?>" /></a>
					<a href="http://www.infosgroup.pl/infostudent/" target="_blank"><img src="<?php echo App::path('img/partnerzy/26.jpg') ?>" /></a>
					<a href="http://www.dlastudenta.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/27.jpg') ?>" /></a>
					<a href="http://www.studentnews.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/28.jpg') ?>" /></a>
					<a href="http://student.lodz.pl/" target="_blank"><img src="<?php echo App::path('img/partnerzy/29.jpg') ?>" /></a>
				</div>
            </div>
    </div>
    <a class="button" href="#intro"><i class="icon-arrow-up"></i> Powrót na górę</a>
</section>-->
</div>

<script id="map-item-template" type="text/x-handlebars-template">
    <p class="action-date"><strong>{{day}} ({{time}})</strong></p>
    <h3>{{title}}</h3>
    <p class="school-address">{{address}}</p>
</script>
