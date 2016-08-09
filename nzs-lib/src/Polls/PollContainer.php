<?php namespace NZS\Core\Polls;

use NZS\Core\ObjectLikeStorage;
use NZS\Core\Polls\Poll;

class PollContainer extends ObjectLikeStorage {
    public function __construct(Poll $poll) {
        $this->poll = $poll;
    }
}
