<?php

use Silverplate\App;

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo get('title', 'Default Title') ?></title>
        <meta name="description" content="<?php echo get('description') ?>">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="<?php echo App::path('css/normalize.css') ?>">
        <link rel="stylesheet" href="<?php echo App::path('css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo App::path('css/720_grid.css') ?>" type="text/css" media="screen and (min-width: 720px)">
        <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:400,700|Roboto+Slab:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo App::path('css/main.css') ?>">
        <script src="<?php echo App::path('js/vendor/modernizr-2.6.2.min.js') ?>"></script>
    </head>
    <body class="<?php echo $type ?> <?php echo get('classes') ?>">
        <!-- PHP Silverplate content -->
        <?php echo $content ?>
        
        <!-- Part of the layout file. Feel free to change the lines below -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo App::path('js/vendor/jquery-1.9.1.min.js') ?>"><\/script>')</script>
        <script src="<?php echo App::path('js/plugins.js') ?>"></script>
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
