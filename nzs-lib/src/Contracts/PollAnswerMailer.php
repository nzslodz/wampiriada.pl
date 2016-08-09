<?php namespace NZS\Core\Contracts;
use NZS\Core\Polls\Answer;

interface PollAnswerMailer {
    public function send(Answer $answer);
}
