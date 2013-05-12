<?php namespace Silverplate; ?>
<?php meta('title', 'Wampiriada w Łodzi') ?>
<?php meta('description', 'Oficjalna strona akcji honorowego krwiodawstwa Wampiriada w Łodzi, organizowanej przez NZS Regionu Łódzkiego. Tutaj dowiesz się, jak wziąć w niej udział.') ?>

<section id="intro">
    <div class="grid">
        <div class="row">
            <h1><img src="<?php echo App::path('img/wampir-logo.png') ?>" alt="Wampiriada - studenckie honorowe krwiodawstwo"></h1>
        </div>
    </div>
    
    <a class="button" href="#schedule"><i class="icon-arrow-down"></i> Znajdź swoją uczelnię</a>
</section>

<section id="schedule">
    <div class="grid">
        <div class="row">
            <header>
                <h2>Terminy 22 akcji Wampiriady</h2>
                <p class="date">05.2013 r. - 06.2013 r.</p>
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
                <li class="row pl">
                    <p class="slot-0 date">13.05</p>
                    <p class="slot-1-2-3 place pl" data-sort="PŁ">PŁ: VIII Dom Studenta</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"></p>
                </li>
                <li class="row um">
                    <p class="slot-0 date">14.05</p>
                    <p class="slot-1-2-3 place um" data-sort="UM">UMed: Centrum Dydaktyczne <small>ul. Pomorska 251</small></p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row ul">
                    <p class="slot-0 date">15.05</p>
                    <p class="slot-1-2-3 place ul" data-sort="UŁ">UŁ: Wydział Zarządzania</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row pl">
                    <p class="slot-0 date">17.05</p>
                    <p class="slot-1-2-3 place pl" data-sort="PŁ">PŁ: Centrum Językowe</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row wsinf">
                    <p class="slot-0 date">18.05</p>
                    <p class="slot-1-2-3 place wsinf" data-sort="WSINF">WSINFiU: Ośrodek Angelica <small>ul. Rzgowska 17a</small></p>
                    <p class="slot-4 time">10 - 14</p>
                    <p class="slot-5 marrow"></p>
                </li>
                <li class="row um">
                    <p class="slot-0 date">20.05</p>
                    <p class="slot-1-2-3 place um" data-sort="UM">UMed: Centrum Dydaktyczne <small>ul. Pomorska 251</small></p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row pl">
                    <p class="slot-0 date">21.05</p>
                    <p class="slot-1-2-3 place pl" data-sort="PŁ">PŁ: Wydział BiNoŻ</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row ul">
                    <p class="slot-0 date">22.05</p>
                    <p class="slot-1-2-3 place ul" data-sort="UŁ">UŁ: Wydział Prawa i Administracji</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"></p>
                </li>
                <li class="row kol">
                    <p class="slot-0 date">26.05</p>
                    <p class="slot-1-2-3 place kol" data-sort="kol">Koluszki: Kino Odeon 3D <small>ul. 3-go Maja 2</small></p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row pl">
                    <p class="slot-0 date">28.05</p>
                    <p class="slot-1-2-3 place pl" data-sort="PŁ">PŁ: Centrum Językowe</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row ul">
                    <p class="slot-0 date">29.05</p>
                    <p class="slot-1-2-3 place ul" data-sort="UŁ">UŁ: Wydział Filologiczny</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row ul">
                    <p class="slot-0 date">03.06</p>
                    <p class="slot-1-2-3 place ul" data-sort="UŁ">UŁ: Wydział Ekonomiczno-Socjologiczny</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
                <li class="row ul">
                    <p class="slot-0 date">04.06</p>
                    <p class="slot-1-2-3 place ul" data-sort="UŁ">UŁ: Centrum WFiS, ul. Styrska 20/24</p>
                    <p class="slot-4 time">10 - 16</p>
                    <p class="slot-5 marrow"><i class="icon-ok"></i> szpik</p>
                </li>
            </ul>

        </div>
    </div>
    
    <a class="button" href="#dontforget"><i class="icon-arrow-down"></i> Czas na fun</a>
</section>
<section id="dontforget">
    <div class="grid">
            <header>
                <h2>To nie wszystko!</h2>
                <p>Zobacz, co jeszcze dla Ciebie przygotowaliśmy.</p>
            </header>

            <div class="row">
                <div class="slot-0-1-2">
                    <p class="center"><img src="<?php echo App::path('img/wampir.png') ?>" alt=""></p>
                    <h3>Gifty</h3>
                    <p>W zamian za oddanie krwi otrzymasz:</p>
                    <ul>
                        <li>osiem czekolad;</li>
                        <li>batonik i napój energetyczny;</li>
                        <li>koszulkę Wampira;</li>
                        <li>zniżkę na pizzę Fiero;</li>
                        <li>oraz zaproszenie na WAMPIRPARTY.</li>
                    </ul>
                </div>
                <div class="slot-3-4-5">
                    <p class="lordis center"><img src="<?php echo App::path('img/lordis.png') ?>" alt="Logo Lordi's Club"></p>
                    <h3>Impreza</h3>
                    <p>Już 30 maja w Lordi's Club przy ul. Piotrkowskiej 102 rozlegną się dźwięki WAMPIRPARTY, imprezy kierowanej do wszystkich honorowych krwiodawców, którzy oddali swoją krew podczas tej edycji Wampiriady. Przyjdź i weź ze sobą znajomych.</p>
                </div>
            </div>

            <div class="row">
                <div class="slot-0-1-2">
                    <h3>Polub nas na Facebooku,</h3>
                    <p>a weźmiesz udział w losowaniu nagród takich jak karnety do Fitfabric Fitness Club, kursów językowych Profilingua, czy darmowych kuponów na pizzę w pizzerii Fiero. Losowanie odbywa się po każdej akcji Wampiriady!</p>
                    <p>Nasz fanpage: <a href="https://www.facebook.com/NZSRegionuLodzkiego">NZS Regionu Łódzkiego</a>.</p>
                </div>
                <div class="slot-3-4-5">
                    <h3>Pozostań w kontakcie</h3>
                    <p>Najświeższe informacje o naszych projektach możesz zdobyć tutaj:</p>
                    <ul>
                        <li><a href="https://www.facebook.com/NZSRegionuLodzkiego">NZS Regionu Łódzkiego</a></li>
                        <li><a href="https://www.facebook.com/wampiriada.nzs.rl">Wampiriada NZS RŁ</a></li>
                        <li><a href="https://www.facebook.com/events/108792442658412/">Oficjalny event 22 edycji Wampiriady</a></li>
                        <li><a href="https://twitter.com/nzslodz">Nasz Twitter</a></li>
                    </ul>
                </div>
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
            
            <div class="row">
                <img src="<?php echo App::path('img/logotypyweb.png') ?>" alt="Logotypy naszych partnerów">
            </div>
    </div>
    <a class="button" href="#intro"><i class="icon-arrow-up"></i> Powrót na górę</a>
</section>
