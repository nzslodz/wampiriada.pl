<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Core\Mailing\MultipleViews;

use NZS\Core\Person;

use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\Redirects\AwareRedirectRepository;

use NZS\Wampiriada\Mailing\WampiriadaReminderEmailJob;

use NZS\Wampiriada\Reminders\Reminder;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\Action;


use Auth;

class WampiriadaReminderMailingComposer extends BaseMailingComposer {
    use MultipleViews;

    protected $action_day;
    protected $edition;

    protected $campaign_name = 'Przypomnienie o oddawaniu krwi wysyłane na 2 dni przed oddaniem';

    protected $subject = 'Wybrana przez Ciebie akcja Wampiriady już za dwa dni! Kilka porad, jak przygotować się do oddania krwi';

    public function __construct(ActionDay $action_day) {
        $this->action_day = $action_day;
        $this->edition = $action_day->edition;
    }

    public function getViews() {
        $view_prefix = 'emails.wampiriada.reminder';

        return [
            "{$view_prefix}.{$this->edition->number}",
            "{$view_prefix}.default",
            $view_prefix,
        ];
    }

    public function getContext(Person $user) {
        $edition_repository = new EditionRepository($this->edition);
        $redirect_repository = $edition_repository->getRedirectRepository();

        $redirect_repository = new AwareRedirectRepository($redirect_repository, $user, $this->getCampaignKey());

        $reminder = Reminder::whereActionDayId($this->action_day->id, $user->id)->first();

        $action = Action::find($this->action_day->id);

        return [
            'user' => $user,
            'composer' => $this,
            'edition' => $this->edition,
            'edition_repository' => $edition_repository,
            'action_day' => $this->action_day,
            'action' => $action,
            'reminder' => $reminder,
            'repository' => $redirect_repository,
        ];
    }

    public function getCampaignKey() {
        return sprintf('w%d:%s', (int) $this->edition->number, 'reminder');
    }

    public function getJobInstance(Person $user) {
        return new WampiriadaReminderEmailJob($this->action_day, $user, get_class($this));
    }

    public static function spawnSampleInstance() {
        $action_day = ActionDay::sortBy('id', 'DESC')->first();

        return new static($action_day);
    }
}
