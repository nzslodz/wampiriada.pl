<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use NZS\Wampiriada\Edition;
use NZS\Core\Person;
use Illuminate\Contracts\Mail\Mailer;
use Exception;
use Storage;

use NZS\Wampiriada\AwareRedirectRepository;
use NZS\Wampiriada\EditionRepository;
use NZS\Core\Mailing\ComposerSender;

class WampiriadaAnnouncementEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user, $edition;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Edition $edition, Person $user) {
        $this->user = $user;
        $this->edition = $edition;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ComposerSender $sender) {
        $composer = new WampiriadaAnnouncementMailingComposer($this->edition);

        $sender->send($composer, $this->user);
    }
}
