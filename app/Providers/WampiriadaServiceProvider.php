<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Wampiriada\EmailCampaignResultActivityClass;
use NZS\Wampiriada\WampiriadaSummaryMailingComposer;
use NZS\Wampiriada\WampiriadaThankYouMailingComposer;
use NZS\Wampiriada\WampiriadaAnnouncementMailingComposer;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use NZS\Core\ActivityRepository;
use NZS\Core\DatabaseActivityRepository;
use NZS\Core\Mailing\MailingRepository;
use NZS\Wampiriada\CheckinActivityClass;
use NZS\Wampiriada\FriendCheckinActivityClass;
use NZS\Wampiriada\PrizeForCheckinActivityClass;

class WampiriadaServiceProvider extends ServiceProvider
{
    public function boot(MailingRepository $repository)
    {
        $repository->register([
            WampiriadaThankYouMailingComposer::class,
            WampiriadaSummaryMailingComposer::class,
            WampiriadaAnnouncementMailingComposer::class
        ]);
    }
}
