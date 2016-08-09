<?php namespace NZS\Core\Contracts;
use NZS\Core\Polls\Poll;

interface PollClass {
    public function resolveInterface($contract, Poll $poll);

    public function allowMultipleResponses();
    public function allowAnonymousResponses();
}
