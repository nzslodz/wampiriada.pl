@extends('layouts.admin')


@section('title')
    Backend NZS
@stop

@section('content')
    <div class="page-header">
        <h1>Dzień dobry :)</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <ul class="nav nav-pills nav-stacked">
                {{-- 
                <li>
                    <a href="{{ url('zgloszenia2') }}">
            
                            @if (Entry2::countNew() > 0)
                                <span class="badge pull-right">{{ Entry2::countNew() }}</span>
                            @endif
                        
                            Kuźnia Liderów 2014
                        </a>
                </li>
            
                <li>
                    <a href="{{ url('zgloszenia') }}">
            
                            @if (Entry::countNew() > 0)
                                <span class="badge pull-right">{{ Entry::countNew() }}</span>
                            @endif
                        
                            Spotkanie z Alexem Barszczewskim
                        </a>
                </li>

                --}}
                
            </ul>
        </div>
    </div>
@stop
