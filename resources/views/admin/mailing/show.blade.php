@extends('layouts.admin')

@section('title')
    {{ $composer->getCampaignName() }}
@stop

@section('content')

    <div class="page-header">
        <h1>
            {{ $composer->getCampaignName() }}
        </h1>

        <p><strong>Temat</strong>: {{ $composer->getSubject($user) }}</p>
    </div>

    <div class="container">
        <iframe scrolling="no" class="mailing-frame" width="800" src="{{ url('admin/mailing/preview?class=' . $class_name) }}"></iframe>
    </div>

@stop

@section('script')
    <script type="text/javascript" src="{{ url('bower_components/iframe-resizer/js/iframeResizer.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('iframe').iFrameResize({minHeight: 600});
        });
    </script>
@stop
