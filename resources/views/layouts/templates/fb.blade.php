
@if(getenv('FACEBOOK_APP_ID'))
    <div id="fb-root"></div>

    @yield('fbinit')

    <script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({
         appId: '{{ getenv('FACEBOOK_APP_ID') }}',
         xfbml: true,
         version: 'v3.0',
         autoLogAppEvents: true,
        });

        if(window.fbHasLoaded) {
            window.fbHasLoaded();
        }
     };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endif
