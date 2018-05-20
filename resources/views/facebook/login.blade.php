@extends('layouts.checkin')

@section('content')
{{--
@if(session('message'))
<div class="alert alert-{{ session('status', 'info') }}" role="alert">
	{{ session('message') }}
</div>
@endif

--}}

<div class="frame form-horizontal" id="application" v-bind:data-view="currentView">
	<div class="views">
		<section-begin></section-begin>
		<section-statistics></section-statistics>
		<section-agreements></section-agreements>
		<section-login-confirm></section-login-confirm>
		<section-success></section-success>
	</div>

	<meta-component></meta-component>
</div>
@stop

@section('datajs')
	<script type="text/javascript">
		var shirtSizes = {!! $sizes !!};
	</script>
@stop
