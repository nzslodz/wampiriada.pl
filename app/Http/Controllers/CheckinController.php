<?php namespace App\Http\Controllers;

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

    public function getLoginPage(Request $request) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();

        if(!$current_action) {
            return view('facebook.login_forbidden');
        }

        $shirt_sizes = ShirtSize::orderBy('id')->pluck('name', 'id');

        return view('facebook.login', [
            'sizes' => $shirt_sizes,
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
    /*
    userInput: {
        bloodType: null,
        chosenSize: null,
        firstTime: false,
        name: null,
        email: null,
        facebook_id: null,

        agreementDataProcessing: false,
        agreementEmailWampiriada: false,
        agreementEmailNZS: false,
    }
     */
    public function postCheckin(CheckinRequest $request) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today())->first();
        if(!$current_action) {
            return abort(403, "Today the process is not available");
        }

        $user = null;

        if($request->facebook_id) {
            $user = Donor::whereFacebookUserId($request->facebook_id)->first();
        }

        if(!$user) {
            $user = Donor::whereEmail($request->email)->first();
        }

        return response()->json(['success' => 1]);

        if(!$user) {
            $user = new Donor;
            $user->facebook_user_id = $request->facebook_id;
            $user->email = $email;

            // XXX TODO
            $user->first_name = $request->name;
            $user->last_name = $request->name;
        }

        $repository = EditionRepository::current();

        // XXX TODO
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
}
