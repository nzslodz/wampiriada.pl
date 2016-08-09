<?php namespace NZS\Core\Contracts;
use NZS\Core\Polls\Answer;
use App\User;

interface PollFlow {
    public function getAnonymousErrorResponse();
    public function getAlreadyAnsweredErrorResponse();
    public function getFormResponse(User $user=null);
    public function getSuccessResponse(Answer $answer);
}
