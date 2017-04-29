<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\Mailing\WampiriadaEmailJob;
use NZS\Wampiriada\Mailing\WampiriadaMailingComposer;
use NZS\Core\Mailing\MultipleViews;

use NZS\Core\Person;
use Storage;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Redirects\AwareRedirectRepository;

abstract class BaseWampiriadaMailingComposer extends BaseMailingComposer implements WampiriadaMailingComposer {
    use MultipleViews;

    protected $edition;

    protected $job_class = WampiriadaEmailJob::class;

    public function __construct(Edition $edition) {
        $this->edition = $edition;
    }

    public function getViews() {
        return [
            "{$this->view_prefix}.{$this->edition->number}",
            "{$this->view_prefix}.default",
            $this->view_prefix,
        ];
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
        $class_name = $this->job_class;

        return new $class_name($this->edition, $user, get_class($this));
    }

    public static function spawnSampleInstance() {
        $edition_repository = new EditionRepository;

        return new static($edition_repository->getEdition());
    }
}
