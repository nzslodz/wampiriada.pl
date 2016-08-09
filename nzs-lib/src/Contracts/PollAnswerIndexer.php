<?php namespace NZS\Core\Contracts;
use NZS\Core\Polls\Answer;

interface PollAnswerIndexer {
    public function saveIndexesOn(Answer $answer);
}
