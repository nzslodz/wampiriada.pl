@extends('layouts.admin')

@section('title')
    Aktywność {{ $user->getFullName() }}
@stop

@section('extrahead')

 <link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
@stop

@section('content')
    <div class="page-header">
        <h2>{{ $user->getFullName() }}</h2>
        <p>Zanotowane {{ $timeline_activity_count }} aktywności</p>
    </div>

    <div id='timeline-embed' style="width: 100%; height: 600px"></div>



@stop

@section('script')
    <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>

    <script type="text/javascript">
      timeline = new TL.Timeline('timeline-embed', {!! json_encode($timeline_json) !!});
    </script>
@stop
