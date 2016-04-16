<?php namespace App\Http\Controllers;

use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;


class FacebookController extends Controller {
    public function getLoginPage(LaravelFacebookSdk $fb) {
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
                redirect('/facebook/login');
                //abort(403, 'Unauthorized action.');
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
        

    }
}
