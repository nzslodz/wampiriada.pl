<?php namespace NZS\Core\Mailing\Courier;
use NZS\Core\Mailing\BaseMailingComposer;
use NZS\Core\Mailing\MultipleViews;
use NZS\Core\Mailing\SimpleEmailJob;

use NZS\Wampiriada\Mailing\WampiriadaReminderEmailJob;

use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Redirects\DatabaseRedirectRepository;

use NZS\Wampiriada\Option;

use Auth;

class CurrentIssueMailingComposer extends BaseMailingComposer {
    use MultipleViews;

    protected $campaign_name = 'Kurier NZS';
    protected $issue = null;

    public function getSubject($user) {
        return sprintf("Kurier NZS (%d)", $this->getCurrentIssue()->number);
    }

    public function getViews() {
        return [
            'emails.courier.issue-' . $this->getCurrentIssue()->number,
            'emails.courier',
        ];
    }

    public function getCurrentIssue() {
        if(!$this->issue) {
            $issue_id = (int) Option::get('courier.issue', 1);

            $this->issue = Issue::find($issue_id);
        }

        return $this->issue;
    }

    public function getCampaignKey() {
        return sprintf("n:issue:%d", $this->getCurrentIssue()->id);
    }

    public function getContext($user) {
        return [
            'user' => $user,
            'composer' => $this,
            'issue' => $this->getCurrentIssue(),
            'repository' => new DatabaseRedirectRepository,
        ];
    }
}
