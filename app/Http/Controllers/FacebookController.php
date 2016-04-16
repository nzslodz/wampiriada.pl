<?php namespace App\Http\Controllers;

use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;
use Session;
use App\User;
use Auth;

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

    public function getCheckin(LaravelFacebookSdk $fb) {
        return view('facebook.checkin');
    }
}
