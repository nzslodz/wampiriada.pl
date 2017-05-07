<?php

namespace NZS\Wampiriada\Mailing;

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
use NZS\Wampiriada\Reminders\Reminder;
use NZS\Core\Mailing\ComposerSender;

class WampiriadaReminderEmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user, $reminder, $composer_class;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Reminder $reminder, Person $user, $composer_class) {
        $this->user = $user;
        $this->reminder = $reminder;
        $this->composer_class = $composer_class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ComposerSender $sender) {
        $class_name = $this->composer_class;

        $composer = new $class_name($this->reminder);

        $sender->send($composer, $this->user);
    }
}
