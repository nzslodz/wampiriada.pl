<?php

namespace NZS\Core\Mailing;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use NZS\Wampiriada\Editions\Edition;
use Illuminate\Contracts\Mail\Mailer;
use Exception;
use Storage;
use NZS\Core\Person;

use NZS\Wampiriada\Redirects\AwareRedirectRepository;
use NZS\Wampiriada\Mailing\WampiriadaThankYouMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Core\Mailing\ComposerSender;

class SimpleEmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user, $composer_class;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Person $user, $composer_class) {
        $this->user = $user;
        $this->composer_class = $composer_class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ComposerSender $sender) {
        $class_name = $this->composer_class;

        $composer = new $class_name;

        $sender->send($composer, $this->user);
    }
}
