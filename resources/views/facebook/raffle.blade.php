@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Wesprzyj Wampiriadę</h1>
            <p>I powiedz całemu światu o naszej akcji!</p>
        </div>

        <div class="row">
            <ul>
                <li>
                    @if($user_likes_wampiriada)
                        <i class="fa fa-check-square-o"></i>
                        Lubisz Fanpage Wampiriady
                    @else
                        <i class="fa fa-square-o"></i>
                        Polub fanpage Wampiriady
                        <div>
                            <div class="fb-like" data-href="https://www.facebook.com/wampiriada.nzs.rl/" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
                        </div>
                    @endif


                </li>
                <li>
                    @if($user_likes_nzs)
                        <i class="fa fa-check-square-o"></i>
                        Lubisz Fanpage NZS
                    @else
                        <i class="fa fa-square-o"></i>
                        Polub Fanpage NZS
                        <div>
                            <div class="fb-like" data-href="https://www.facebook.com/NZSRegionuLodzkiego" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
                        </div> 
                    @endif

                </li>
                <li>
                    <i class="fa fa-square-o"></i> Powiadom innych, że oddjesz krew.
                </li>
            </ul>
        </div>

        {{ Form::open(array('url' => '/facebook/raffle', 'class' => 'form-horizontal')) }}
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    {{ Form::submit('Wyślij', ['class' => 'btn btn-primary btn-big']) }}
                    <a href="{{ url('/facebook/complete') }}">Dziękuję, nie chcę</a>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@stop

@section('fbextra')
    FB.Event.subscribe('edge.create', function(response) {console.log(response)});
@stop
