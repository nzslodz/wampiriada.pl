<?php namespace NZS\Wampiriada;

use Silverplate\App;
use Netzmacht\Html\Element;
use Illuminate\Database\Eloquent\Model as Model;

use App\Contracts\Redirect as RedirectContract;

class AwareRedirect implements RedirectContract {
    protected 
        $redirect,
        $email_campaign_key,
        $user_md5email;

    public function __construct(RedirectContract $redirect) {
        $this->redirect = $redirect;
    }

    public function setEmailCampaign($email_campaign) {
        $this->email_campaign_key = $email_campaign->key;
    }

    public function setUser($user) {
        $this->user_md5email = $user->md5email;
    }

    public function withUser($user) {
        $this->setUser($user);
        return $this;
    }

    public function withCampaign($campaign) {
        $this->setEmailCampaign($campaign);
        return $this;
    }

    public function exists() {
        return $this->redirect->exists();
    }

    public function generateQueryString() {
        if(!$this->email_campaign_key || !$this->user_md5email) {
            return '';
        }

        return "?c=" . urlencode($this->email_campaign_key) . '&m=' . $this->user_md5email;
    }

    public function asUrl() {
        if(!$this->exists()) {
            return '';
        }

        return $this->redirect->asUrl() . $this->generateQueryString();
    }

    public function __toString() {
        return $this->asUrl();
    }
}

