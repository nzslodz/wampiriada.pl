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
    public function handle(Mailer $mailer) {
        $edition_repository = new EditionRepository($this->edition);

        $campaign_key = 'w' . $edition_repository->getEditionNumber() .':initial-response';

        $database_repository = new DatabaseRedirectRepository;
        $database_repository->registerRedirect('wampiriada', 'http://wampiriada.pl');

        $wampiriada_repository = new WampiriadaRedirectRepository(new EditionRepository($edition_number));
        $wampiriada_repository->registerRedirect('mailing-img', 'http://nzs.lodz.pl/newsletter/wampi28-mailing-official.jpg');

        $repository = new CompositeRedirectRepository([$wampiriada_repository, $database_repository]);

        $repository = new AwareRedirectRepository($repository, $this->user, $campaign_key);

        $has_facebook_photo = $this->user->facebook_user_id && Storage::disk('local')->exists("fb-images/{$this->user->facebook_user_id}.jpg");

        $mailer->send('emails.wampiriada.thankyou', [
                'user' => $this->user,
                'edition' => $this->edition,
                'repository' => $repository,
                'has_facebook_photo' => $has_facebook_photo,
                'registered_through_facebook' => (bool) $this->user->facebook_user_id,
            ], function($m) {
                $m->to($this->user->email, $this->user->getFullName());
                $m->subject('Wampiriada - 28. edycja. Dziękujemy że jesteś z nami!');
            }
        );
    }
}
