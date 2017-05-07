<?php namespace NZS\Core\Polls;
use NZS\Core\Person;

trait MatchesUserWithEmail {
    public function getUser() {
        if(property_exists($this, 'email_field')) {
            $email_field = $this->email_field;
        } else {
            $email_field = 'email';
        }

        return Person::whereEmail($this->input($email_field))->first();
    }
}
