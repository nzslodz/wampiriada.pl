<?php namespace NZS\Core\Polls;
use App\User;

trait MatchesUserWithEmail {
    public function getUser() {
        if(property_exists($this, 'email_field')) {
            $email_field = $this->email_field;
        } else {
            $email_field = 'email';
        }

        return User::whereEmail($this->input($email_field))->first();
    }
}
