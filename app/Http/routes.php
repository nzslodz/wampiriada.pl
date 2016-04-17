<?php

use App\Http\Middleware\AdminMiddleware;

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

//Route::group(['middleware' => 'auth'], function() {
    Route::get('/facebook/checkin', 'FacebookController@getCheckin');
    Route::post('/facebook/checkin', 'FacebookController@postCheckin');
//});

// mobile controller
//Route::get('data/overall', 'MobileController@getOverall');

// newsletter controller - remove yourself from newsletter, 
//Route::get('newsletter/remove', 'NewsletterController@getRemove');

Route::group(['prefix' => 'admin'], function() {
	// Login/forgot_password/reset_password
	//Route::get( 'user/forgot_password',        'UserController@forgot_password');
	//Route::post('user/forgot_password',        'UserController@do_forgot_password');
	//Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
	//Route::post('user/reset_password',         'UserController@do_reset_password');

	// XXX TODO add a gate or sth
	Route::group(array('middleware' => ['auth', AdminMiddleware::class]), function() {

	    //Route::controller('zgloszenia', 'EntryController');
	    //Route::controller('zgloszenia2', 'Entry2Controller');
	    Route::get('wampiriada', 'WampiriadaBackendController@getIndex');
	    Route::get('wampiriada/show/{number}', 'WampiriadaBackendController@getShow');
	    Route::get('wampiriada/edit/{number}', 'WampiriadaBackendController@getEdit');
	    Route::post('wampiriada/edit/{number}', 'WampiriadaBackendController@postEdit');
	    Route::post('wampiriada/results', 'WampiriadaBackendController@postResults');
	    Route::get('wampiriada/settings/{number}', 'WampiriadaBackendController@getSettings');
	    Route::post('wampiriada/settings/{number}', 'WampiriadaBackendController@postSettings');

	    Route::get('/', function() {
	    	return View::make('admin.hello');
	    });

	});
});

Route::auth();
