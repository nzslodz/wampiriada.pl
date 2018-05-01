<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResultActivityClass;
use NZS\Wampiriada\Mailing\WampiriadaPartyMailingComposer;
use NZS\Wampiriada\Mailing\WampiriadaSummaryMailingComposer;
use NZS\Wampiriada\Mailing\WampiriadaThankYouMailingComposer;
use NZS\Wampiriada\Mailing\WampiriadaReminderMailingComposer;
use NZS\Wampiriada\Mailing\WampiriadaAnnouncementMailingComposer;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use NZS\Core\ActivityRepository;
use NZS\Core\DatabaseActivityRepository;
use NZS\Core\Mailing\MailingRepository;
use NZS\Wampiriada\Checkins\CheckinActivityClass;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinActivityClass;

class WampiriadaServiceProvider extends ServiceProvider
{
    public function boot(MailingRepository $repository)
    {
        $repository->register([
            WampiriadaThankYouMailingComposer::class,
            WampiriadaSummaryMailingComposer::class,
            WampiriadaAnnouncementMailingComposer::class,
            WampiriadaReminderMailingComposer::class,
            WampiriadaPartyMailingComposer::class,
        ]);
    }
}
