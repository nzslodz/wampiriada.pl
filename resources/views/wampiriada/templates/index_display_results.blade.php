@if($display_results)
<section id="results">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <header>
                    <h2>Wyniki {{ $repository->getEditionNumber() }}. edycji Wampiriady</h2>
                    <p class="date">{{ $repository->getEdition()->getStartDate()->format('m.Y') }} - {{ $repository->getEdition()->getEndDate()->format('m.Y') }} r.</p>
                </header>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="overall @if($results->sum('overall') > 1000) smallfont @endif">
                <div class="big">{{ $results->sum('overall') }}</div> 
                <div class="small">{{ $oddalo($results->sum('overall')) }} krew</div>

                <div class="note">{{ $results->sum('overall') * 0.45 }}</div>
                <div class="foot">litrów krwi</div>
            </div>
        </div>
        <div class="col-md-8">
                <div id="magicalchart" class="row" style="height: 460px"
                    data-zero-minus="{{ $results->sum('zero_minus') }}"
                    data-zero-plus="{{ $results->sum('zero_plus') }}"
                    data-a-minus="{{ $results->sum('a_minus') }}"
                    data-a-plus="{{ $results->sum('a_plus') }}"
                    data-b-minus="{{ $results->sum('b_minus') }}"
                    data-b-plus="{{ $results->sum('b_plus') }}"
                    data-ab-plus="{{ $results->sum('ab_plus') }}"
                    data-ab-minus="{{ $results->sum('ab_minus') }}"
                    data-unknown="{{ $results->sum('unknown') }}"
                ></div>
        </div>
    </div>
    </div>
</section>
@endif
