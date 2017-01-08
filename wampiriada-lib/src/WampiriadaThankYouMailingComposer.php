<?php namespace NZS\Wampiriada;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\EditionRepository;
use NZS\Wampiriada\WampiriadaMailingComposer;
use App\Jobs\WampiriadaThankYouEmail;
use NZS\Core\Mailing\MultipleViews;

use App\User;
use Storage;

class WampiriadaThankYouMailingComposer extends BaseMailingComposer implements WampiriadaMailingComposer {
    use MultipleViews;

    protected $edition;

    protected $campaign_key = 'initial-response';
    protected $campaign_name = 'Mail z podziękowaniem po oddaniu krwi';

    public function __construct(Edition $edition) {
        $this->edition = $edition;
    }

    protected function getSubject() {
        return "Wampiriada - {$this->edition->number}. edycja. Dziękujemy że jesteś z nami!";
    }

    public function getViews() {
        return [
            "emails.wampiriada.thankyou.{$this->edition->number}",
            "emails.wampiriada.thankyou.default",
        ];
    }

    public function getContext(User $user) {
        $edition_repository = new EditionRepository($this->edition);
        $repository = $edition_repository->getRedirectRepository();

        $repository = new AwareRedirectRepository($repository, $user, $this->getCampaignKey());

        $has_facebook_photo = $user->facebook_user_id && Storage::disk('local')->exists("fb-images/{$user->facebook_user_id}.jpg");

        return [
            'user' => $user,
            'composer' => $this,
            'edition' => $this->edition,
            'repository' => $repository,
            'has_facebook_photo' => $has_facebook_photo,
            'registered_through_facebook' => (bool) $user->facebook_user_id,
        ];
    }

    public function getCampaignKey() {
        return sprintf('w%d:%s', (int) $this->edition->number, $this->campaign_key);
    }

    public function getJobInstance(User $user) {
        return new WampiriadaThankYouEmail($this->edition, $user);
    }

    public static function spawnSampleInstance() {
        $edition_repository = new EditionRepository;

        return new static($edition_repository->getEdition());
    }

    public function getSampleContext(User $user) {
        return $this->getContext($user);
    }
}
