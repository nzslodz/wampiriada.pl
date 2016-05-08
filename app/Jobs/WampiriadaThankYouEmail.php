<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use NZS\Wampiriada\Edition;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Exception;

class WampiriadaThankYouEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user, $edition;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Edition $edition, User $user) {
        $this->user = $user;
        $this->edition = $edition;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer) {
        $mailer->send('emails.wampiriada.thankyou', ['user' => $this->user, 'edition' => $this->edition], function($m) {
            $m->to($this->user->email, $this->user->getFullName());
            $m->subject('Wampiriada - Dziękujemy za oddanie krwi!');
        });
    }
}