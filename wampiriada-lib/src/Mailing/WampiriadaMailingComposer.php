<?php namespace NZS\Wampiriada\Mailing;

use NZS\Wampiriada\Editions\Edition;

interface WampiriadaMailingComposer {
    public function __construct(Edition $edition);
}
