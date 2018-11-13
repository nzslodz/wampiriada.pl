@section('extrahead-recaptcha')
    <script src='https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}'></script>
@stop

<input id="g-recaptcha-response" type="hidden" name="g-recaptcha-response" value="">

<script type="text/javascript">
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ env('GOOGLE_RECAPTCHA_KEY') }}', {action: '{{ $action }}'})
        .then(function(token) {
            document.getElementById('g-recaptcha-response').value = token
        });
    });
</script>
