<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WampiriadaController@showIndex');
Route::get('/redirect/{name}', 'WampiriadaController@getRedirect');
Route::get('/redirect/{edition_id}/{name}', 'WampiriadaController@getRedirect');

Route::get('/facebook/login', 'FacebookController@getLoginPage');
Route::get('/facebook/callback', 'FacebookController@getCallback');

Route::group(['before' => 'auth'], function() {
    Route::get('/facebook/checkin', 'FacebookController@getCheckin');
    Route::post('/facebook/checkin', 'FacebookController@postCheckin');
});
