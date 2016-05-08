<h2>{{ $_SERVER['REQUEST_METHOD'] }} {{ $_SERVER['REQUEST_URI'] }}</h2>
<h3>{{ $exception->getMessage() }} (code {{ $exception->getCode() }})</h3>

<p>{{ get_class($exception) }} thrown at {{ $exception->getFile() }}:{{ $exception->getLine() }}</p>

@if(!empty($context))
<h4>Context</h4>
	<dl>
	@foreach($context as $key=>$value)
		<div>
			<dt style="display: inline; color: #a0a000; font-weight: bold">{{ $key }}</dt>
			<dd style="display: inline">{{ $value }}</dd>
		</div>
	@endforeach
	</dl>
@endif

<h4>Stack trace</h4>
<pre>
{{ $exception->getTraceAsString() }}
</pre>

<h4>Request</h4>
<dl>
	@foreach($_REQUEST as $key=>$value)
		<div>
			<dt style="display: inline; color: #a0a000; font-weight: bold">{{ $key }}</dt>
			<dd style="display: inline">{{ $value }}</dd>
		</div>
	@endforeach
</dl>

