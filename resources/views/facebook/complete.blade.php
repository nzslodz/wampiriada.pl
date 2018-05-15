@extends('layouts.checkin')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Dziękujemy!</h1>
            @if(!$hide_email_login_checkout)
            <p>Wylogowaliśmy Cię z Facebooka automatycznie. Nic więcej nie musisz robić. :) Ta strona przeładuje się samoczynnie za 10 sekund.</p>
            @else
            <p>Dziękujemy za wpisanie się na listę. Nic więcej nie musisz robić. :) Ta strona przeładuje się samoczynnie za 10 sekund.</p>
            @endif
        </div>

        <script type="text/javascript">
            setTimeout(function() {
                location.href = '{{ url('facebook/login') }}'
            }, 10000)
        </script>
    </div>


@stop
