<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Core\Mailing\MultipleViews;

use NZS\Wampiriada\Editions\EditionRepository;

use NZS\Wampiriada\Mailing\WampiriadaReminderEmailJob;

use NZS\Wampiriada\Reminders\Reminder;
use NZS\Wampiriada\ActionDay;
use NZS\Core\Exceptions\ObjectDoesNotExist;

use Auth;

class WampiriadaReminderMailingComposer extends BaseMailingComposer {
    use MultipleViews;

    protected $action_day;
    protected $edition;

    protected $campaign_name = 'Przypomnienie o oddawaniu krwi wysyłane na 2 dni przed oddaniem';

    protected $subject = 'Wybrana przez Ciebie akcja Wampiriady już niebawem! Kilka porad, jak przygotować się do oddania krwi';

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

    public function getContext($user) {
        $edition_repository = new EditionRepository($this->edition);
        $redirect_repository = $edition_repository->getRedirectRepository();

        $reminder = Reminder::whereActionDayId($this->action_day->id, $user->id)->first();

        try {
            $actions = $edition_repository->getFutureActions();
        } catch(ObjectDoesNotExist $e) {
            $actions = collect();
        }

        $school_mapping = array(
            'UŁ' => '#c2812c',
            'PŁ' => '#b72b2a',
            'UMed' => '#71953d',
        );

        $color = function($short_name) use($school_mapping) {
            return isset($school_mapping[$short_name])? $school_mapping[$short_name]: "#c14d8f";
        };

        return [
            'user' => $user,
            'composer' => $this,
            'edition' => $this->edition,
            'edition_repository' => $edition_repository,
            'action_day' => $this->action_day,
            'actions' => $actions,
            'reminder' => $reminder,
            'repository' => $redirect_repository,
            'color' => $color,
        ];
    }

    public function getCampaignKey() {
        return sprintf('w%d:%s', (int) $this->edition->number, 'reminder');
    }

    public function getJobInstance($user) {
        return new WampiriadaReminderEmailJob($this->action_day, $user, get_class($this));
    }

    public static function spawnSampleInstance() {
        $action_day = ActionDay::orderBy('id', 'DESC')->first();

        return new static($action_day);
    }
}
