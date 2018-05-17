<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;

use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Mailing\BaseWampiriadaMailingComposer;

class WampiriadaSummaryMailingComposer extends BaseWampiriadaMailingComposer {
    protected $campaign_key = 'after-edition';
    protected $campaign_name = 'Mail z podziękowaniem po zakończeniu edycji';

    protected $subject = 'Podziękowanie XXX TODO';

    protected $view_prefix = 'emails.wampiriada.summary';
}
