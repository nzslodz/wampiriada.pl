<?php namespace NZS\Wampiriada\Mailing;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Core\Mailing\MultipleViews;
use NZS\Core\Mailing\SimpleEmailJob;


use NZS\Wampiriada\Mailing\WampiriadaReminderEmailJob;

use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Redirects\DatabaseRedirectRepository;

use Auth;

class PrivacyPolicyUpdateMailingComposer extends BaseMailingComposer {
    protected $campaign_name = 'Wampiriada 2018 - aktualizacja polityki prywatności oraz Newsletter NZS';

    protected $subject = 'Wampiriada - aktualizacja polityki prywatności oraz Newsletter NZS';

    protected $view = 'emails.wampiriada.privacy_policy_update';

    protected $campaign_key = 'w2018:privacy_policy';

    public function getContext($user) {
        return [
            'user' => $user,
            'composer' => $this,
            'repository' => new DatabaseRedirectRepository,
        ];
    }
}
