<?php namespace App\Http\Controllers;

use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;
use Session;
use App\User;
use Auth;
use App\Http\Requests\CheckinRequest;

use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\BloodType;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\Profile;
use Carbon\Carbon;

class FacebookController extends Controller {
    public function getLoginPage(LaravelFacebookSdk $fb) {
        Session::forget('fb_user_access_token');
        
        $login_url = $fb->getLoginUrl();

        return view('facebook.login', ['login_url' => $login_url]);
    }

    public function getCallback(LaravelFacebookSdk $fb) {
        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch(FacebookSDKException $e) {
            dd($e->getMessage());
        }

        if(!$token) {
            $helper = $fb->getRedirectHelper();

            if(!$helper->getError()) {
                redirect('/facebook/login')->with('message', 'Logowanie zostało odrzucone.');
            }

            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }

        if(!$token->isLongLived()) {
            $oauth_client = $fb->getOAuth2Client();

            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch(FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }

        $fb->setDefaultAccessToken($token);

        Session::put('fb_user_access_token', (string) $token);

        try {
            $response = $fb->get('/me?fields=email,id,first_name,last_name');
        } catch(FacebookSDKException $e) {
            dd($e->getMessage());
        }

        $facebook_user = $response->getGraphUser();

        $user = User::createOrUpdateGraphNode($facebook_user);
        $user->username = $user->email;
        $user->save();

        Auth::login($user);

        return redirect('/facebook/checkin');
    }

    /* XXX TODO show first_time only if  */ 
    public function getCheckin(LaravelFacebookSdk $fb) {
        $profile = Profile::whereId(Auth::user()->id)->first();
        if(!$profile) {
            $profile = new Profile;
        }

        return view('facebook.checkin', [
            'sizes' => ShirtSize::orderBy('id')->pluck('name', 'id'),
            'blood_types' => BloodType::orderBy('name')->pluck('name', 'id'),
            'first_time' => true,
            'profile' => $profile,
        ]);
    }

    public function postCheckin(CheckinRequest $request) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        if(!$current_action) {
            return abort(403, "Today the process is not available");
        }

        $checkin = new Checkin();
        $checkin->first_time = $request->has('first_time');
        $checkin->size_id = $request->size;
        $checkin->blood_type_id = $request->blood_type;
        $checkin->name = $request->name;
        $checkin->action_day_id = $current_action->id;
        $checkin->edition_id = $current_action->edition_id;
        $checkin->user_id = Auth::user()->id;

        $checkin->save();

        $profile = Profile::whereId(Auth::user()->id)->first();
        if(!$profile) {
            $profile = new Profile;
            $profile->id = Auth::user()->id;
        }

        $profile->current_name = $request->name;
        $profile->default_size_id = $request->size;
        $profile->blood_type_id = $request->blood_type;
        $profile->save();

        return redirect('/facebook/raffle');
    }
}
