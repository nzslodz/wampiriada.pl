<?php namespace App\Http\Controllers;

use Session;
use NZS\Core\PersonNewspaper;
use App\Http\Requests\CheckinRequest;
use App\Http\Requests\EmailLoginRequest;
use Illuminate\Http\Request;

use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\Donor;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\EditionRepository;
use Carbon\Carbon;

use App\Jobs\DownloadFacebookProfileThenMakeGraphics;
use App\Jobs\WampiriadaThankYouEmail;
use App\Jobs\RegenerateTileImage;

use NZS\Wampiriada\WampiriadaThankYouMailingComposer;

use App\Libraries\ErrorMailer;
use LogicException;
use Mail;
use DB;
use Cookie;

use Storage;

/*
 * This controller is responsible for maintaining a promotional action
 * copying http://100000.pb.pl/
 *
 * A Donor logs in through Facebok through a very simple interface and
 * then a custom image is being procesed for them with their profile picture
 * and a randomized text.
 *
 * After logging in and generating the image they are able to share
 * (through javascript FB SDK) the image to their wall.
 */

// XXX remove - use JS for that

class FacebookNewspaperController extends Controller {
    const SESSION_ACCESS_TOKEN = 'nn_fb_user_access_token';
    const SESSION_USER_ID = 'nn_user_id';

    const SAVE_COOKIE_NAME = 'nn_user_cookie';

    public function getPage(Request $request, LaravelFacebookSdk $fb) {
        $logged_user_id = $request->session()->get(self::SESSION_USER_ID);
        $logged_user = Donor::find($logged_user_id);

        if(!$logged_user) {
            $login_url =  $fb->getLoginUrl(['email'], '/nzs/callback');
            $newspaper = null;
        } else {
            $login_url = null;
            $newspaper = PersonNewspaper::find($logged_user->id);
        }

        // then find an user through campaign token
        $loggable_user_token = $request->cookie(self::SAVE_COOKIE_NAME);
        $loggable_user = Donor::whereCampaignToken($loggable_user_token)->first();

        return view('nn_facebook.page', [
            'login_url' => $login_url,
            'logged_user' => $logged_user,
            'loggable_user' => $loggable_user,
            'newspaper' => $newspaper,
        ]);
    }


    public function getCallback(LaravelFacebookSdk $fb, Request $request, ErrorMailer $error_mailer) {
        try {
            $token = $fb->getAccessTokenFromRedirect('/nzs/callback');
        } catch(FacebookSDKException $e) {
            $error_mailer->mailException($e);

            return redirect('/nzs')
                ->with('status', 'warning')
                ->with('message', 'Wystąpił błąd podczas logowania. Spróbuj ponownie.');
        }

        if(!$token) {
            $helper = $fb->getRedirectLoginHelper();

            if(!$helper->getError()) {
                return redirect('/nzs')
                    ->with('status', 'warning')
                    ->with('message', 'Logowanie zostało odrzucone. Prosimy zalogować się ponownie.');
            }

            $error_mailer->mail($helper->getError(), [
                'code' => $helper->getErrorCode(),
                'reason' => $helper->getErrorReason(),
                'description' => $helper->getErrorDescription(),
            ]);

            return redirect('/nzs')
                ->with('status', 'warning')
                ->with('message', 'Logowanie nie powiodło się. Spróbuj ponownie.');
        }

        $fb->setDefaultAccessToken($token);

        $request->session()->flash(self::SESSION_ACCESS_TOKEN, (string) $token);

        try {
            $response = $fb->get('/me?fields=email,id,first_name,last_name,gender');
        } catch(FacebookSDKException $e) {
            $error_mailer->mailException($e);

            return redirect('/nzs')
                ->with('status', 'warning')
                ->with('message', 'Wystąpił błąd podczas pobierania informacji o profilu. Spróbuj ponownie.');
        }

        $facebook_user = $response->getGraphUser();

        $user = Donor::createOrUpdateGraphNode($facebook_user);
        $user->updateGender($facebook_user);
        $user->save();

        $newspaper = PersonNewspaper::findOrNew($user->id);
        $newspaper->generateFilename();
        $newspaper->id = $user->id;
        $newspaper->save();

        $request->session()->flash(self::SESSION_USER_ID, $user->id);

        Cookie::queue(self::SAVE_COOKIE_NAME, $user->campaign_token);

        Session::put('checkin_user_id', $user->id);

        dispatch(new DownloadFacebookProfileThenMakeGraphics($user));

        // XXX SEND AND DISPATCH EMAIL for a few hours ahead

        return redirect('/nzs')
            ->cookie(self::SAVE_COOKIE_NAME, $user->campaign_token, 60*24*30);
    }

    public function postPollImage(Request $request) {
        $newspaper = PersonNewspaper::whereFilename($request->input('filename'))->firstOrFail();

        $image_path = $newspaper->getImagePath();

        if(!$image_path) {
            return response()->json(['url' => null], 202);
        }

        return response()->json(['url' => Storage::url($image_path)]);
    }
}
