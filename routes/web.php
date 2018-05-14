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
Route::get('/krew', 'WampiriadaController@getKrew');
Route::get('/szpik', 'WampiriadaController@getSzpik');

Route::get('/reminder/{action_day_id}', 'WampiriadaController@getReminder');
Route::post('/reminder/{action_day_id}', 'WampiriadaController@postReminder');

Route::get('/reminder_ok', 'WampiriadaController@getReminderSuccess');

/*
Route::get('/dziekujemy/ankieta', 'WampiriadaController@showThankYouMailingPoll');
Route::post('/dziekujemy/ankieta', 'WampiriadaController@saveThankYouMailingPoll');
*/

Route::get('/facebook/login', 'CheckinController@getLoginPage');
Route::post('/facebook/login', 'CheckinController@postLoginViaEmailPage');
Route::get('/facebook/callback', 'CheckinController@getCallback');
Route::get('/facebook/callback/{to}', 'CheckinController@getCallback');
Route::get('/privacy_policy', 'CheckinController@getPrivacyPolicy');

Route::group(['middleware' => 'auth.checkin'], function() {
    Route::get('/facebook/checkin', 'CheckinController@getCheckin');
    Route::post('/facebook/checkin', 'CheckinController@postCheckin');
    Route::get('/facebook/complete', 'CheckinController@getComplete');
});

Route::get('/nzs', 'FacebookNewspaperController@getPage');
Route::post('/nzs/poll_image', 'FacebookNewspaperController@postPollImage');
Route::get('/nzs/callback', 'FacebookNewspaperController@getCallback');

// newsletter controller - remove yourself from newsletter,
Route::get('newsletter/remove', 'NewsletterController@getRemove');
Route::post('newsletter/remove', 'NewsletterController@postRemove');

Route::group(['prefix' => 'admin'], function() {
	// Login/forgot_password/reset_password
	//Route::get( 'user/forgot_password',        'UserController@forgot_password');
	//Route::post('user/forgot_password',        'UserController@do_forgot_password');
	//Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
	//Route::post('user/reset_password',         'UserController@do_reset_password');

	Route::group(array('middleware' => ['auth', AdminMiddleware::class]), function() {

	    //Route::controller('zgloszenia', 'EntryController');
	    //Route::controller('zgloszenia2', 'Entry2Controller');
	    Route::get('wampiriada', 'WampiriadaBackendController@getIndex');
	    Route::get('wampiriada/list', ['as' => 'admin-wampiriada-list', 'uses' => 'WampiriadaBackendController@getList']);
	    Route::get('wampiriada/new', ['as' => 'admin-wampiriada-new', 'uses' => 'WampiriadaBackendController@getNew']);
	    Route::get('wampiriada/show/{number}', ['as' => 'admin-wampiriada-show', 'uses' => 'WampiriadaBackendController@getShow']);
	    Route::get('wampiriada/edit/{number}', ['as' => 'admin-wampiriada-edit', 'uses' =>'WampiriadaBackendController@getEdit']);
	    Route::post('wampiriada/edit/{number}', 'WampiriadaBackendController@postEdit');
	    Route::post('wampiriada/results', 'WampiriadaBackendController@postResults');
	    Route::get('wampiriada/settings/{number}', ['as' => 'admin-wampiriada-settings', 'uses' => 'WampiriadaBackendController@getSettings']);
	    Route::post('wampiriada/settings/{number}', 'WampiriadaBackendController@postSettings');

        Route::post('wampiriada/prize/{checkin}', 'WampiriadaBackendController@postPrize');
        Route::get('wampiriada/prize/summary/{number}', [ 'as' =>'admin-wampiriada-prize-summary', 'uses' => 'WampiriadaBackendController@prizeSummary'] );

        Route::get('prize', ['as' => 'admin-prize-list', 'uses' => 'PrizeController@getIndex']);
        Route::get('prize/create', ['as' => 'admin-prize-create', 'uses' => 'PrizeController@getEdit']);
        Route::post('prize/create', 'PrizeController@postEdit');
        Route::get('prize/edit/{id}', ['as' => 'admin-prize-edit', 'uses' => 'PrizeController@getEdit']);
        Route::post('prize/edit/{id}', 'PrizeController@postEdit');
        Route::post('prize/toggle/{type}', 'PrizeController@postToggle');

	    Route::get('email', ['as' => 'email-list', 'uses' => 'MailController@getIndex']);
	    Route::get('email/create', ['as' => 'email-create', 'uses' => 'MailController@getCreate']);
	   	Route::post('email/create', 'MailController@postCreate');

        Route::get('mailing', ['as' => 'admin-mailing-list', 'uses' => 'MailingController@getIndex']);
        Route::get('mailing/preview', ['as' => 'admin-mailing-preview', 'uses' => 'MailingController@getPreview']);
        Route::get('mailing/show', ['as' => 'admin-mailing-show', 'uses' => 'MailingController@getShow']);

        Route::get('activity/profile/{user}', ['as' => 'activity-profile', 'uses' => 'ActivityController@getProfile']);

        Route::get('activity/card/{user}','ActivityController@getProfileCard');

	    Route::get('/', ['as' => 'admin-home', function() {
	    	return View::make('admin.hello');
	    }]);

        Route::get('/test/example', 'TestController@getTest');

        Route::get('trello/releases', ['as' => 'admin-trello-releases', 'uses' => 'TrelloController@getIndex']);
        Route::get('trello/releases/create/{key}', ['as' => 'admin-trello-releases-create', 'uses' => 'TrelloController@showBoardCardsForRelease']);
        Route::post('trello/releases/create/{key}', 'TrelloController@postRelease');
        Route::get('trello/releases/{key}/{list}', ['as' => 'admin-trello-single-release', 'uses' => 'TrelloController@getRelease']);


        Route::group(['prefix' => 'hr'], function() {
            Route::get('autocomplete', ['as' => 'admin-hr-members-create', 'uses' => 'HRController@getPersonAutocomplete']);

            Route::group(['prefix' => 'members'], function() {
                Route::get('/', ['as' => 'admin-hr-members-list', 'uses' => 'HRController@getMemberIndex']);
                Route::get('create', ['as' => 'admin-hr-members-create', 'uses' => 'HRController@getCreateMember']);
                Route::get('{id}', ['as' => 'admin-hr-members-show', 'uses' => 'HRController@getMember']);
                Route::get('{id}/edit', ['as' => 'admin-hr-members-edit', 'uses' => 'HRController@getUpdateMember']);
                Route::get('{id}/delete', ['as' => 'admin-hr-members-delete', 'uses' => 'HRController@getDeleteMember']);

                Route::post('create', 'HRController@postCreateMember');
                Route::post('{id}/edit', 'HRController@postUpdateMember');
                Route::post('{id}/delete', 'HRController@postDeleteMember');
            });

            Route::group(['prefix' => 'events'], function() {
                Route::get('/', ['as' => 'admin-hr-events-list', 'uses' => 'HREventController@getIndex']);
                Route::get('create', ['as' => 'admin-hr-events-create', 'uses' => 'HREventController@getUpdate']);
                Route::get('{id}/edit', ['as' => 'admin-hr-events-edit', 'uses' => 'HREventController@getUpdate']);
                Route::get('{id}', ['as' => 'admin-hr-events-show', 'uses' => 'HREventController@getAttendances']);


                Route::post('create', 'HREventController@postUpdate');
                Route::post('{id}/edit', 'HREventController@postUpdate');
                Route::post('{id}','HREventController@postAttendances');
            });

            Route::group(['prefix' => 'gender'], function() {
                Route::get('/', ['as' => 'admin-hr-gender-index', 'uses' => 'HRGenderController@getIndex']);
                Route::get('{id}/edit', ['as' => 'admin-hr-gender-edit', 'uses' => 'HRGenderController@getGender']);

                Route::post('{id}/edit', 'HRGenderController@postGender');
            });
        });


	});
});

Route::auth();
// hack
Route::get('/logout', 'Auth\LoginController@logout');
