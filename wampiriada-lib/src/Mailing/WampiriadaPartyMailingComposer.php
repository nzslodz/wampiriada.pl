<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;

use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Mailing\BaseWampiriadaMailingComposer;

class WampiriadaPartyMailingComposer extends BaseWampiriadaMailingComposer {
    protected $campaign_key = 'party';
    protected $campaign_name = 'Mail ogłaszający Wampirparty';

    protected $view_prefix = 'emails.wampiriada.party';


    public function getSubject($user) {
        if($this->edition->number == 30) {
            return "Wampirparty - weź udział w imprezie VR w Virtual House";
        }

        if($this->edition->number == 34) {
            return "Wampirparty - ODWYK po Wampiriadzie!";
        }

        return "{$this->edition->number}. edycja Wampiriady - czas na Wampirparty!";
    }

}
