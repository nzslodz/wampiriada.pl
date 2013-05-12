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
    
    <a class="button" href="#dontforget"><i class="icon-arrow-down"></i> Pamiętaj także o</a>
</section>
<section id="dontforget">
    <div class="grid">
    </div>
</section>
<section id="who">
    <div class="grid">
    </div>
</section>
<section id="partners">
    <div class="grid">
    </div>
</section>
