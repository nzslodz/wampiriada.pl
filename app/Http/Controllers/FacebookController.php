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
use NZS\Wampiriada\FriendCheckin;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\Profile;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\FacebookConnection;
use NZS\Wampiriada\EditionRepository;
use Carbon\Carbon;

use App\Jobs\DownloadFacebookProfile;
use App\Jobs\WampiriadaThankYouEmail;
use App\Jobs\RegenerateTileImage;

use NZS\Wampiriada\AwareRedirectRepository;
use NZS\Wampiriada\FirstTimeDonatingActivityClass;
use NZS\Wampiriada\WampiriadaThankYouMailingComposer;

use App\Libraries\ErrorMailer;
use LogicException;
use Mail;
use DB;

use Storage;

class FacebookController extends Controller {
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
        Auth::logout();

        $login_url = $fb->getLoginUrl();
        $is_facebook_login_enabled = (bool) Option::get('wampiriada.facebook_login', true);

        // XXX RESTYLE THIS
        return view('facebook.login', [
            'login_url' => $login_url,
            'is_facebook_login_enabled' => $is_facebook_login_enabled,
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

        Session::put('hide_email_login_checkout', 1);

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

            ErrorMailer::mail($helper->getError(), [
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

        try {
            $response = $fb->get('/me/friends?fields=id');

            $graphEdge = $response->getGraphEdge();

            while($graphEdge) {
                foreach($graphEdge as $graphNode) {
                    $user_id = $graphNode->getField('id');

                    if($target_user = User::whereFacebookUserId($user_id)->first()) {
                        FacebookConnection::firstOrCreate(['source_id' => $user->id, 'target_id' => $target_user->id]);
                        FacebookConnection::firstOrCreate(['source_id' => $target_user->id, 'target_id' => $user->id]);
                    }
                }

                $graphEdge = $fb->next($graphEdge);
            }
        } catch(facebookSDKException $e) {
            ErrorMailer::mailException($e);
        }

        // XXX: not needed really
        if(Session::get('to') == 'finish') {
            Session::forget('to');
            return redirect('/facebook/finish');
        }

        return redirect('/facebook/checkin');
    }

    public function getCheckin(LaravelFacebookSdk $fb) {
        $profile = Profile::whereId(Auth::user()->id)->first();
        $hide_email_login_checkout = Session::get('hide_email_login_checkout', false);

        if(!$profile || $hide_email_login_checkout) {
            $profile = new Profile;
        }

        $user = Auth::user();
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
            'first_time' => !(Checkin::whereUserId(Auth::user()->id)->exists()),
            'profile' => $profile,
            'hide_email_login_checkout' => $hide_email_login_checkout,
            'user' => Auth::user(),
        ]);
    }

    public function postCheckin(CheckinRequest $request, LaravelFacebookSdk $fb) {
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

        DB::transaction(function() use($request, $current_action, $user) {
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

            // create activity object for first-time donation
            if($checkin->first_time) {
                $activity_class = new FirstTimeDonatingActivityClass;
                $activity_class->saveActivityInstance($checkin);
            }

            $facebook_connections = FacebookConnection::whereSourceId($user->id)->get();

            foreach($facebook_connections as $connection) {
                $friend = Checkin::whereEditionId($current_action->edition_id)->whereUserId($connection->target_id)->first();
                if(!$friend) {
                    continue;
                }

                $reverse_connection = FacebookConnection::whereTargetId($connection->source_id)->whereSourceId($connection->target_id)->first();

                FriendCheckin::firstOrCreate([
                    'facebook_connection_id' => $connection->id,
                    'checkin_id' => $checkin->id,
                    'friend_checkin_id' => $friend->id,
                ]);

                FriendCheckin::firstOrCreate([
                    'facebook_connection_id' => $reverse_connection->id,
                    'checkin_id' => $friend->id,
                    'friend_checkin_id' => $checkin->id,
                ]);
            }

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

            $user_has_changed = false;

            // fix user first_name/last_name
            if(!$user->first_name && !$user->last_name) {
                list($user->first_name, $user->last_name) = $profile->getNameAsPair();
                $user_has_changed = true;
            }

            if(!$user->email) {
                $user->email = $request->email;
                $user_has_changed = true;
            }

            if($user_has_changed) {
                $user->save();
            }
        });

        $composer = new WampiriadaThankYouMailingComposer($edition);
        // XXX: zdispatchować manualnie e-maila jak już wszystko będzie gotowe (taskiem)
        //dispatch($composer->getJobInstance($user)->delay(7200));
        //dispatch(new RegenerateTileImage());

        $token = Session::get('fb_user_access_token');

        if(!$token) {
            return redirect('/facebook/complete');
        }

        $fb->setDefaultAccessToken($token);

        return redirect($fb->getRedirectLoginHelper()->getLogoutUrl($token,  url('facebook/complete')));
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
        return view('facebook.complete', [
            'hide_email_login_checkout' => Session::get('hide_email_login_checkout', false),
        ]);
    }
}
