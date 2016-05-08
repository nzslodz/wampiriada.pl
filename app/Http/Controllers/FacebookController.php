<?php namespace App\Http\Controllers;

use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;
use Session;
use App\User;
use Auth;
use App\Http\Requests\CheckinRequest;
use App\Http\Requests\EmailLoginRequest;
use Illuminate\Http\Request;

use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\BloodType;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\Profile;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\EditionRepository;
use Carbon\Carbon;

use App\Jobs\DownloadFacebookProfile;
use App\Jobs\WampiriadaThankYouEmail;

use App\Libraries\ErrorMailer;
use LogicException;

use Storage;

class FacebookController extends Controller {
    public function getLoginPage(LaravelFacebookSdk $fb) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        // XXX do this
        if(!$current_action) {
            return view('facebook.login_forbidden');
        }

        Session::forget('fb_user_access_token');
        Auth::logout();

        $login_url = $fb->getLoginUrl();

        // XXX RESTYLE THIS
        return view('facebook.login', [
            'login_url' => $login_url
        ]);
    }

    public function postLoginViaEmailPage(EmailLoginRequest $request) {
        $user = User::firstOrCreate(['email' => $request->email]);

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

        Auth::login($user);

        return redirect('/facebook/checkin');
    }

    public function getCallback(LaravelFacebookSdk $fb, Request $request) {
        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch(FacebookSDKException $e) {
            ErrorMailer::mailException($e);

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

            ErrorMailer($helper->getError(), [
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
            ErrorMailer::mailException($e);

            return redirect('/facebook/login')
                ->with('status', 'warning')
                ->with('message', 'Wystąpił błąd podczas pobierania informacji o profilu. Spróbuj ponownie.');
        }

        $facebook_user = $response->getGraphUser();

        $user = User::createOrUpdateGraphNode($facebook_user);
        $user->username = $user->email;
        $user->save();

        Auth::login($user);

        dispatch(new DownloadFacebookProfile($user));

        // XXX: not needed really
        if(Session::get('to') == 'finish') {
            Session::forget('to');
            return redirect('/facebook/finish');
        }

        return redirect('/facebook/checkin');
    }

    public function getCheckin(LaravelFacebookSdk $fb) {
        $profile = Profile::whereId(Auth::user()->id)->first();
        if(!$profile) {
            $profile = new Profile;
        }

        $user = Auth::user();
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
            'first_time' => !(Checkin::whereUserId(Auth::user()->id)->first()),
            'profile' => $profile,
        ]);
    }

    public function postCheckin(CheckinRequest $request) {
        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        if(!$current_action) {
            return abort(403, "Today the process is not available");
        }

        $user = Auth::user();

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

        // save checkin model
        $checkin = new Checkin();
        $checkin->first_time = $request->has('first_time');
        $checkin->size_id = $request->size;
        $checkin->blood_type_id = $request->blood_type;
        $checkin->name = $request->name;
        $checkin->action_day_id = $current_action->id;
        $checkin->edition_id = $current_action->edition_id;
        $checkin->user_id = Auth::user()->id;

        $checkin->save();

        // save profile defaults
        $profile = Profile::whereId(Auth::user()->id)->first();
        if(!$profile) {
            $profile = new Profile;
            $profile->id = Auth::user()->id;
        }

        $profile->current_name = $request->name;
        $profile->default_size_id = $request->size;
        $profile->blood_type_id = $request->blood_type;
        $profile->save();

        dispatch(new WampiriadaThankYouEmail($edition, $user));

        // XXX queue friend processing

        return redirect('/facebook/complete');
    }

    /*
    public function getRaffle(LaravelFacebookSdk $fb) {
        $token = Session::get('fb_user_access_token');

        if(!$token) {
            abort(403, 'Not authorized');
        }

        $fb->setDefaultAccessToken($token);

        $user_likes_wampiriada = false;
        $user_likes_nzs = false;

        try {
            # Wampiriada
            $wamp_response = $fb->get('/me/likes/110146435762751');
            # NZS
            $nzs_response = $fb->get('/me/likes/150737411647566');
        } catch(FacebookSDKException $e) {
            dd($e->getMessage());
        }

        foreach($wamp_response->getGraphEdge() as $graph_node) {
            if($graph_node['id']) {
                $user_likes_wampiriada = true;
            }
        }
        
        foreach($nzs_response->getGraphEdge() as $graph_node) {
            if($graph_node['id']) {
                $user_likes_nzs = true;
            }
        }

        return view('facebook.raffle', [
            'user_likes_wampiriada' => $user_likes_wampiriada,
            'user_likes_nzs' => $user_likes_nzs,
        ]);
    }

    public function postRaffle(LaravelFacebookSdk $fb) {
        $login_url = $fb->getLoginUrl(['user_likes', 'publish_actions']);
        
        Session::set('to', 'finish');
        
        return redirect($login_url);
    }*/

    /*public function getFinish(LaravelFacebookSdk $fb) {
        $token = Session::get('fb_user_access_token');

        if(!$token) {
            abort(403, 'Not authorized');
        }

        $fb->setDefaultAccessToken($token);
       
        $edition_repository = new EditionRepository(Option::get('wampiriada.edition', 28));
        $redirect = $edition_repository->getRedirect('plakat');

        try {
            $data = [
                'link' => $redirect->asUrl(),
                'message' => 'Test message',
            ];

            $fb->post("/me/feed", $data);
        } catch(FacebookSDKException $e) {
            dd($e->getMessage());
        }


        $current_action = ActionDay::whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        $checkin = Checkin::whereActionDayId($current_action->id)->whereUserId(Auth::user()->id)->first();

        if(!$checkin) {
            abort(403, 'Forbidden');
        }

        $checkin->qualified_for_raffle = true;
        $checkin->save();

        return redirect($fb->getRedirectLoginHelper()->getLogoutUrl($token,  url('facebook/complete')));
    }*/

    public function getComplete() {
        return view('facebook.complete');
    }
}
