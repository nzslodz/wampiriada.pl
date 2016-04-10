<?php

use Silverplate\App;

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="pl"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="pl"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="pl"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pl"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo get('title', 'Default Title') ?></title>
        <meta name="description" content="<?php echo get('description') ?>">
        <meta name="viewport" content="width=device-width">

<link rel="apple-touch-icon" sizes="57x57" href="<?= App::path('img/icons/apple-touch-icon-57x57.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="60x60" href="<?= App::path('img/icons/apple-touch-icon-60x60.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="72x72" href="<?= App::path('img/icons/apple-touch-icon-72x72.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="76x76" href="<?= App::path('img/icons/apple-touch-icon-76x76.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="114x114" href="<?= App::path('img/icons/apple-touch-icon-114x114.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="120x120" href="<?= App::path('img/icons/apple-touch-icon-120x120.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="144x144" href="<?= App::path('img/icons/apple-touch-icon-144x144.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="152x152" href="<?= App::path('img/icons/apple-touch-icon-152x152.png') ?>?v=allLWkmAnX">
<link rel="apple-touch-icon" sizes="180x180" href="<?= App::path('img/icons/apple-touch-icon-180x180.png') ?>?v=allLWkmAnX">
<link rel="icon" type="image/png" href="<?= App::path('img/icons/favicon-32x32.png') ?>?v=allLWkmAnX" sizes="32x32">
<link rel="icon" type="image/png" href="<?= App::path('img/icons/android-chrome-192x192.png') ?>?v=allLWkmAnX" sizes="192x192">
<link rel="icon" type="image/png" href="<?= App::path('img/icons/favicon-96x96.png') ?>?v=allLWkmAnX" sizes="96x96">
<link rel="icon" type="image/png" href="<?= App::path('img/icons/favicon-16x16.png') ?>?v=allLWkmAnX" sizes="16x16">
<link rel="manifest" href="<?= App::path('img/icons/manifest.json') ?>?v=allLWkmAnX">
<link rel="mask-icon" href="<?= App::path('img/icons/safari-pinned-tab.svg') ?>?v=allLWkmAnX" color="#cb2b28">
<link rel="shortcut icon" href="<?= App::path('img/icons/favicon.ico') ?>?v=allLWkmAnX">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="<?= App::path('img/icons/mstile-144x144.png') ?>?v=allLWkmAnX">
<meta name="msapplication-config" content="<?= App::path('img/icons/browserconfig.xml') ?>?v=allLWkmAnX">
<meta name="theme-color" content="#ffffff">

        <meta name="og:image" content="<?php echo App::path('img/wampir-logo-2.png') ?>">

        <link rel="stylesheet" href="<?php echo App::path('bower_components/font-awesome/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo App::path('bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" ?>
        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo App::path('css/main.css') ?>?r=4">
        <script src="<?php echo App::path('js/vendor/modernizr-2.6.2.min.js') ?>"></script>
    </head>
    <body class="<?php echo $type ?> <?php echo get('classes') ?>">
        
 <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.3&appId=214270901970539";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>       
        <!-- PHP Silverplate content -->
        <?php echo $content ?>
        
        <!-- Part of the layout file. Feel free to change the lines below -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo App::path('js/vendor/jquery-1.9.1.min.js') ?>"><\/script>')</script>
        <script src="<?php echo App::path('js/plugins.js') ?>"></script>
		
		<!--skrypty z map google-->
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
		<script type="text/javascript" src="<?php echo App::path('bower_components/gmaps/gmaps.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo App::path('bower_components/isotope/dist/isotope.pkgd.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo App::path('bower_components/jquery.scrollTo/jquery.scrollTo.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo App::path('bower_components/handlebars/handlebars.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo App::path('js/vendor/canvasjs/canvasjs.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo App::path('bower_components/responsive-bootstrap-toolkit/dist/bootstrap-toolkit.min.js') ?>"></script>
		
        <script src="<?php echo App::path('js/main.js') ?>"></script>
        <script src="http://accept-cookie.cdn.lambdadelta.pl/jquery.accept-cookie.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-36686663-3'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
