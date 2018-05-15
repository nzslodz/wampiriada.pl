<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;

use NZS\Core\Person;

use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Redirects\AwareRedirectRepository;
use NZS\Wampiriada\Mailing\BaseWampiriadaMailingComposer;

class WampiriadaPartyMailingComposer extends BaseWampiriadaMailingComposer {
    protected $campaign_key = 'party';
    protected $campaign_name = 'Mail ogłaszający Wampirparty';

    protected $view_prefix = 'emails.wampiriada.party';

    protected $subject = "Wampirparty - weź udział w imprezie VR w Virtual House";
}
