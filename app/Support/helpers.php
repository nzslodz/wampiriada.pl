<?php

if(!function_exists('app_mix')) {
    function app_mix($path) {
        return mix($path, getenv('APP_ENV') == 'production' ? 'dist': 'local');
    }
}
