<?php namespace NZS\Core\Mailing;

use Illuminate\Contracts\Mail\Mailer;

use NZS\Core\Contracts\MailingComposer;
use NZS\Core\Person;

class ComposerSender {
    protected $mailer;

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function send(MailingComposer $composer, Person $user) {
        $this->mailer->send($composer->getView(), $composer->getContext($user), function($m) use($user, $composer) {
                $m->to($user->email, $user->getFullName());
                $m->subject($composer->getSubject($user));
            }
        );
    }
}
