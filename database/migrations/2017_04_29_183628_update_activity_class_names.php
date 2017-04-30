<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Core\Activity;
use NZS\Core\Redirects\Redirect;

use NZS\Wampiriada\Checkins\CheckinActivityClass;
use NZS\Wampiriada\Checkins\FirstTimeDonatingActivityClass;

use NZS\Wampiriada\Checkins\Friend\FriendCheckinActivityClass;

use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinActivityClass;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinClaimedActivityClass;

use NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResultActivityClass;
use NZS\Wampiriada\Redirects\WampiriadaRedirectRepository;

class UpdateActivityClassNames extends Migration
{
    protected $mapping = [
        'NZS\Wampiriada\PrizeForCheckinClaimedActivityClass' => PrizeForCheckinClaimedActivityClass::class,
        'NZS\Wampiriada\EmailCampaignResultActivityClass' => EmailCampaignResultActivityClass::class,
        'NZS\Wampiriada\CheckinActivityClass' => CheckinActivityClass::class,
        'NZS\Wampiriada\FirstTimeDonatingActivityClass' => FirstTimeDonatingActivityClass::class,
        'NZS\Wampiriada\PrizeForCheckinActivityClass' => PrizeForCheckinActivityClass::class,
        'NZS\Wampiriada\FriendCheckinActivityClass' => FriendCheckinActivityClass::class,
    ];

    protected $redirect_mapping = [
        'NZS\Wampiriada\WampiriadaRedirectRepository' => WampiriadaRedirectRepository::class,
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->mapping as $old_class => $new_class) {
            Activity::whereClassName($old_class)->update([
                'class_name' => $new_class,
            ]);
        }

        foreach($this->redirect_mapping as $old_class => $new_class) {
            Redirect::whereClassName($old_class)->update([
                'class_name' => $new_class,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->mapping as $old_class => $new_class) {
            Activity::whereClassName($new_class)->update([
                'class_name' => $old_class,
            ]);
        }

        foreach($this->redirect_mapping as $old_class => $new_class) {
            Redirect::whereClassName($new_class)->update([
                'class_name' => $old_class,
            ]);
        }
    }
}
