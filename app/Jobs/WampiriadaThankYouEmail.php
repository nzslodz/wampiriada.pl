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
use Storage;

use NZS\Wampiriada\AwareRedirectRepository;
use NZS\Wampiriada\EditionRepository;

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
    public function handle(ComposerSender $sender) {
        $composer = new WampiriadaThankYouMailingComposer($this->edition);

        $sender->send($composer, $this->user);
    }
}
