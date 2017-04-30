<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;

use NZS\Core\Person;

use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Redirects\AwareRedirectRepository;
use NZS\Wampiriada\Mailing\BaseWampiriadaMailingComposer;

class WampiriadaAnnouncementMailingComposer extends BaseWampiriadaMailingComposer {
    protected $campaign_key = 'announcement';
    protected $campaign_name = 'Mail z ogłoszeniem nowej edycji Wampiriady';

    protected $view_prefix = 'emails.wampiriada.announcements';

    public function getSubject(Person $user) {
        return "{$this->edition->number}. edycja Wampiriady - poznaj terminy akcji :)";
    }

    public function getContext(Person $user) {
        $context = parent::getContext($user);

        try {
            $actions = $context['edition_repository']->getActions();
        } catch(ObjectDoesNotExist $e) {
            $actions = [];
        }

        $context['actions'] = $actions;

        return $context;     
    }
}
