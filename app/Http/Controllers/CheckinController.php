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
use App;

use Storage;

class CheckinController extends Controller {
    public function getPrivacyPolicy() {
        return view('facebook.privacy_policy');
    }

    public function getLoginPage(Request $request, LaravelFacebookSdk $fb) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        // XXX do this
        if(!$current_action) {
            return view('facebook.login_forbidden');
        }

        $request->session()->forget('fb_user_access_token');
        $request->session()->forget('hide_email_login_checkout');
        $request->session()->forget('checkin_user_id');

        $is_facebook_login_enabled = (bool) Option::get('wampiriada.facebook_login', true);

        if($is_facebook_login_enabled) {
            $login_url = $fb->getLoginUrl(['email']);
        } else {
            $login_url = null;
        }

        $shirt_sizes = ShirtSize::orderBy('id')->pluck('name', 'id');

        // XXX RESTYLE THIS
        return view('facebook.login', [
            'login_url' => $login_url,
            'is_facebook_login_enabled' => $is_facebook_login_enabled,
            'sizes' => $shirt_sizes,
            'user' => null,
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

        $request->session()->put('checkin_user_id', $user->id);
        $request->session()->put('hide_email_login_checkout', 1);

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

        $request->session()->put('fb_user_access_token', (string) $token);

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

        $request->session()->put('checkin_user_id', $user->id);

        // XXX
        dispatch(new DownloadFacebookProfile($user));

        return redirect('/facebook/checkin');
    }

    public function getCheckin(Request $request, LaravelFacebookSdk $fb) {
        $user = Donor::find($request->session()->get('checkin_user_id'));

        if(!$user) {
            throw new LogicException("/checkin url used without user being created.");
        }

        $hide_email_login_checkout = $request->session()->get('hide_email_login_checkout', false);

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

        return view('facebook.checkin', [
            'sizes' => $shirt_sizes,
            'first_time' => !(Checkin::whereUserId($user->id)->exists()),
            'hide_email_login_checkout' => $hide_email_login_checkout,
            'user' => $user,
        ]);
    }

    public function postCheckin(CheckinRequest $request, LaravelFacebookSdk $fb) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today())->first();
        if(!$current_action) {
            return abort(403, "Today the process is not available");
        }

        $user = Donor::find($request->session()->get('checkin_user_id'));
        if(!$user) {
            throw new LogicException("POST on /checkin url used without user being created.");
        }

        $repository = EditionRepository::current();

        $checkin = Checkin::whereUserId($user->id)->whereEditionId($repository->getEdition()->id)->first();
        if($checkin) {
            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Nie można oddawać krwi dwa razy w trakcie jednej edycji.');
        }

        DB::transaction(function() use($repository, $request, $user) {
            $repository->checkin($user, $request);
        });

        // XXX check this
        $composer = new WampiriadaThankYouMailingComposer($repository->getEdition());

        $job = $composer->getJobInstance($user);
        if(App::environment('production')) {
            $job->delay(Carbon::now()->addHours(2));
        }

        dispatch($job);

        // XXX check this
        dispatch(new RegenerateTileImage());

        $token = $request->session()->get('fb_user_access_token');

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
