<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;
use App\Jobs\WampiriadaAnnouncementEmail;

use NZS\Core\Person;

use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Redirects\AwareRedirectRepository;

class WampiriadaAnnouncementMailingComposer extends BaseMailingComposer implements WampiriadaMailingComposer {
    protected $edition;

    protected $campaign_key = 'announcement';
    protected $campaign_name = 'Mail z ogłoszeniem nowej edycji Wampiriady';

    public function getView() {
        // XXX: if view exists

        return 'emails.wampiriada.announcements.'. $this->edition->number;
    }

    public function getSubject(Person $user) {
        return "{$this->edition->number}. edycja Wampiriady - poznaj terminy akcji :)";
    }

    public function __construct(Edition $edition) {
        $this->edition = $edition;
    }

    public function getContext(Person $user) {
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

    public function getJobInstance(Person $user) {
        return new WampiriadaAnnouncementEmail($this->edition, $user);
    }

    public static function spawnSampleInstance() {
        $edition_repository = new EditionRepository;

        return new static($edition_repository->getEdition());
    }

    public function getSampleContext(Person $user) {
        return $this->getContext($user);
    }
}
