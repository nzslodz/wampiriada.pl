<?php namespace NZS\Core\Contracts;

interface PollFormRequest {
    public function getSanitizedData();
    public function getUser();
}
