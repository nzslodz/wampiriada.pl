<?php namespace NZS\Core\Contracts;
use NZS\Core\Polls\Poll;

interface PollPresenter {
    public function getView();
    public function getViewContext();
}
