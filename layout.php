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

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <meta name="og:image" content="<?php echo App::path('img/wampir-logo-2.png') ?>">

        <link rel="stylesheet" href="<?php echo App::path('css/normalize.css') ?>">
        <link rel="stylesheet" href="<?php echo App::path('css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo App::path('css/720_grid.css') ?>" type="text/css" media="screen and (min-width: 720px)">
        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo App::path('css/main.css') ?>?r=2">
        <script src="<?php echo App::path('js/vendor/modernizr-2.6.2.min.js') ?>"></script>
    </head>
    <body class="<?php echo $type ?> <?php echo get('classes') ?>">
        <!-- PHP Silverplate content -->
        <?php echo $content ?>
        
        <!-- Part of the layout file. Feel free to change the lines below -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo App::path('js/vendor/jquery-1.9.1.min.js') ?>"><\/script>')</script>
        <script src="<?php echo App::path('js/plugins.js') ?>"></script>
		
		<!--skrypty z map google-->
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
		<script type="text/javascript" src="<?php echo App::path('bower_components/gmaps/gmaps.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo App::path('bower_components/handlebars/handlebars.min.js') ?>"></script>
		
		
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
