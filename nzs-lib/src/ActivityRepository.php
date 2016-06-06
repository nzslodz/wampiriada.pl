<?php namespace NZS\Core;

interface ActivityRepository {
    public function registerActivityEvents();
    public function append($item);
}
