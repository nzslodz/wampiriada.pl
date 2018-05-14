<?php namespace App\Http\Controllers;

use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;
use Session;
use App\Http\Requests\CheckinRequest;
use App\Http\Requests\EmailLoginRequest;
use Illuminate\Http\Request;

use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\BloodType;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Editions\EditionRepository;
use Carbon\Carbon;

use App\Jobs\DownloadFacebookProfile;
use App\Jobs\RegenerateTileImage;

use NZS\Wampiriada\Mailing\WampiriadaThankYouMailingComposer;
use NZS\Wampiriada\Donor;

use App\Libraries\ErrorMailer;
use LogicException;
use Mail;
use DB;

use Storage;

class CheckinController extends Controller {
    public function getPrivacyPolicy() {
        return view('facebook.privacy_policy');
    }

    public function getLoginPage(LaravelFacebookSdk $fb) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        // XXX do this
        if(!$current_action) {
            return view('facebook.login_forbidden');
        }

        Session::forget('fb_user_access_token');
        Session::forget('hide_email_login_checkout');
        Session::forget('checkin_user_id');

        $login_url = $fb->getLoginUrl(['email']);
        $is_facebook_login_enabled = (bool) Option::get('wampiriada.facebook_login', true);

        // XXX RESTYLE THIS
        return view('facebook.login', [
            'login_url' => $login_url,
            'is_facebook_login_enabled' => $is_facebook_login_enabled,
        ]);
    }

    public function postLoginViaEmailPage(EmailLoginRequest $request) {
        $user = Donor::firstOrCreate(['email' => $request->email]);

        $edition_number = Option::get('wampiriada.edition', 28);
        $edition = Edition::whereNumber($edition_number)->first();
        if(!$edition) {
            throw new LogicException("Edition does not exist for number $edition_number");
        }

        $checkin = Checkin::whereUserId($user->id)->whereEditionId($edition->id)->first();
        if($checkin) {
            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Nie można oddawać krwi dwa razy w trakcie jednej edycji.');
        }

        Session::put('checkin_user_id', $user->id);
        Session::put('hide_email_login_checkout', 1);

        return redirect('/facebook/checkin');
    }

    public function getCallback(LaravelFacebookSdk $fb, Request $request, ErrorMailer $error_mailer) {
        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch(FacebookSDKException $e) {
            $error_mailer->mailException($e);

            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Wystąpił błąd podczas logowania. Spróbuj ponownie.');
        }

        if(!$token) {
            $helper = $fb->getRedirectLoginHelper();

            if(!$helper->getError()) {
                return redirect('/facebook/login')
                    ->with('status', 'warning')
                    ->with('message', 'Logowanie zostało odrzucone. Prosimy zalogować się ponownie.');
            }

            $error_mailer->mail($helper->getError(), [
                'code' => $helper->getErrorCode(),
                'reason' => $helper->getErrorReason(),
                'description' => $helper->getErrorDescription(),
            ]);

            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Logowanie nie powiodło się. Spróbuj ponownie.');
        }

        $fb->setDefaultAccessToken($token);

        Session::put('fb_user_access_token', (string) $token);

        try {
            $response = $fb->get('/me?fields=email,id,first_name,last_name');
        } catch(FacebookSDKException $e) {
            $error_mailer->mailException($e);

            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Wystąpił błąd podczas pobierania informacji o profilu. Spróbuj ponownie.');
        }

        $facebook_user = $response->getGraphUser();

        $user = Donor::createOrUpdateGraphNode($facebook_user);
        $user->save();

        Session::put('checkin_user_id', $user->id);

        dispatch(new DownloadFacebookProfile($user));

        return redirect('/facebook/checkin');
    }

    public function getCheckin(LaravelFacebookSdk $fb) {
        $user = Donor::find(Session::get('checkin_user_id'));

        if(!$user) {
            throw new LogicException("/checkin url used without user being created.");
        }

        $hide_email_login_checkout = Session::get('hide_email_login_checkout', false);

        if($hide_email_login_checkout) {
            $user->first_name = null;
            $user->last_name = null;
        }

        $edition_number = Option::get('wampiriada.edition', 28);
        $edition = Edition::whereNumber($edition_number)->first();
        if(!$edition) {
            throw new LogicException("Edition does not exist for number $edition_number");
        }

        $checkin = Checkin::whereUserId($user->id)->whereEditionId($edition->id)->first();
        if($checkin) {
            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Nie można oddawać krwi dwa razy w trakcie jednej edycji.');
        }

        $shirt_sizes = ShirtSize::orderBy('id')->pluck('name', 'id');
        $shirt_sizes->prepend('---', "");
        $blood_types = BloodType::orderBy('name')->pluck('name', 'id');
        $blood_types->prepend('---', "");

        return view('facebook.checkin', [
            'sizes' => $shirt_sizes,
            'blood_types' => $blood_types,
            'first_time' => !(Checkin::whereUserId($user->id)->exists()),
            'hide_email_login_checkout' => $hide_email_login_checkout,
            'user' => $user,
        ]);
    }

    public function postCheckin(CheckinRequest $request, LaravelFacebookSdk $fb) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        if(!$current_action) {
            return abort(403, "Today the process is not available");
        }

        $user = Donor::find(Session::get('checkin_user_id'));
        if(!$user) {
            throw new LogicException("POST on /checkin url used without user being created.");
        }

        $edition_number = Option::get('wampiriada.edition', 28);
        $edition = Edition::whereNumber($edition_number)->first();
        if(!$edition) {
            throw new LogicException("Edition does not exist for number $edition_number");
        }

        $checkin = Checkin::whereUserId($user->id)->whereEditionId($edition->id)->first();
        if($checkin) {
            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Nie można oddawać krwi dwa razy w trakcie jednej edycji.');
        }

        $blood_type = BloodType::findOrFail($request->blood_type);

        // Update ActionData
        $action_data = ActionData::firstOrNew(['id' => $current_action->id]);
        $action_data->{$blood_type->key} += 1;
        $action_data->save();

        DB::transaction(function() use($request, $current_action, $user) {
            // save checkin model
            $checkin = new Checkin();
            $checkin->first_time = $request->filled('first_time');
            $checkin->size_id = $request->size;
            $checkin->blood_type_id = $request->blood_type;
            $checkin->name = $request->name;
            $checkin->action_day_id = $current_action->id;
            $checkin->edition_id = $current_action->edition_id;
            $checkin->user_id = $user->id;

            $checkin->save();

            $user_has_changed = false;

            // fix user first_name/last_name
            /*if(!$user->first_name && !$user->last_name) {
                list($user->first_name, $user->last_name) = $profile->getNameAsPair();
                $user_has_changed = true;
            }*/

            if(!$user->email) {
                $user->email = $request->email;
                $user_has_changed = true;
            }

            if($user_has_changed) {
                $user->save();
            }
        });

        $composer = new WampiriadaThankYouMailingComposer($edition);

        dispatch($composer->getJobInstance($user)->delay(Carbon::now()->addHours(2)));
        dispatch(new RegenerateTileImage());

        $token = Session::get('fb_user_access_token');

        if(!$token) {
            return redirect('/facebook/complete');
        }

        $fb->setDefaultAccessToken($token);

        return redirect($fb->getRedirectLoginHelper()->getLogoutUrl($token,  url('facebook/complete')));
    }

    public function getComplete() {
        return view('facebook.complete', [
            'hide_email_login_checkout' => Session::get('hide_email_login_checkout', false),
        ]);
    }
}
