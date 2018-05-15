<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;

use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Mailing\BaseWampiriadaMailingComposer;

class WampiriadaAnnouncementMailingComposer extends BaseWampiriadaMailingComposer {
    protected $campaign_key = 'announcement';
    protected $campaign_name = 'Mail z ogłoszeniem nowej edycji Wampiriady';

    protected $view_prefix = 'emails.wampiriada.announcements';

    public function getSubject($user) {
        if($this->edition->number == 30) {
            return "Majówka z Wampirem + Terminy 30. edycji Wampiriady!";
        }

        return "{$this->edition->number}. edycja Wampiriady - poznaj terminy akcji :)";
    }

    // XXX color function
    public function getContext($user) {
        $context = parent::getContext($user);

        try {
            $actions = $context['edition_repository']->getActions();
        } catch(ObjectDoesNotExist $e) {
            $actions = [];
        }

        $context['actions'] = $actions;

        $school_mapping = array(
            'UŁ' => '#c2812c',
            'PŁ' => '#b72b2a',
            'UMed' => '#71953d',
        );

        $color = function($short_name) use($school_mapping) {
            return isset($school_mapping[$short_name])? $school_mapping[$short_name]: "#c14d8f";
        };

        $context['color'] = $color;

        return $context;
    }
}
