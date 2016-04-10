@if($display_results)
<section id="results">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>Wyniki {{ $repository->getEdition() }}. edycji Wampiriady</h2>
                    <p class="date">11.2015 r. - 12.2015 r.</p>
                </header>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="overall @if($results->overall > 1000) smallfont @endif">
                <div class="big">{{ $results->overall }}</div> 
                <div class="small">{{ $oddalo($results->overall) }} krew</div>

                <div class="note">{{ $results->overall * 0.45 }}</div>
                <div class="foot">litrów krwi</div>
            </div>
        </div>
        <div class="col-md-8">
                <div id="magicalchart" class="row" style="height: 460px"
                    data-zero-minus="{{ $results->zero_minus }}"
                    data-zero-plus="{{ $results->zero_plus }}"
                    data-a-minus="{{ $results->a_minus }}"
                    data-a-plus="{{ $results->a_plus }}"
                    data-b-minus="{{ $results->b_minus }}"
                    data-b-plus="{{ $results->b_plus }}"
                    data-ab-plus="{{ $results->ab_plus }}"
                    data-ab-minus="{{ $results->ab_minus }}"   
                    data-unknown="{{ $results->unknown }}"
                ></div>
        </div>
    <!--    
    <div class="row thanks">
        <p>
            Wampiriada zakończona! Wedle oficjalnych informacji z Regionalnego Centrum Krwiodawstwa, udało się zebrać aż {{ $results->overall * 0.45 }} litrów krwi{{ $overall_difference ? ",": "." }}
            @if($overall_difference)
                czyli <strong>o {{ $overall_difference }} litra więcej niż na ostatniej</strong> jesiennej Wampiriadzie.
            @endif
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
@endif
