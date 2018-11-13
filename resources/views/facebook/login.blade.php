@extends('layouts.checkin')

@section('content')
{{--
@if(session('message'))
<div class="alert alert-{{ session('status', 'info') }}" role="alert">
	{{ session('message') }}
</div>
@endif

--}}

<div class="frame form-horizontal" id="application" v-bind:data-view="currentSlide">
	<div class="views" :style="viewsWidth">
		<section-begin></section-begin>
		<section-statistics></section-statistics>
		<section-agreements></section-agreements>
		<section-login-confirm v-if="!loginStepDisabled"></section-login-confirm>
		<section-success></section-success>
	</div>

	<meta-component>
		<template slot="privacy-policy">
			@include('facebook.privacy_policy_contents')
		</template>
	</meta-component>
</div>
@stop

@section('datajs')
	<script type="text/javascript">
		var shirtSizes = {!! $sizes !!};
	</script>
@stop
