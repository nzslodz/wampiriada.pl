<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\Mailing\WampiriadaMailingComposer;
use NZS\Wampiriada\Mailing\BaseWampiriadaMailingComposer;
use NZS\Core\Mailing\MultipleViews;

use Storage;
use NZS\Wampiriada\Editions\Edition;

class WampiriadaThankYouMailingComposer extends BaseWampiriadaMailingComposer {
    protected $campaign_key = 'initial-response';
    protected $campaign_name = 'Mail z podziękowaniem po oddaniu krwi';

    protected $view_prefix = 'emails.wampiriada.thankyou';

    public function getSubject($user) {
        return "Wampiriada - {$this->edition->number}. edycja. Dziękujemy że jesteś z nami!";
    }
}
