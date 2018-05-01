<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCheckinActivityClasses extends Migration
{
    protected $classes = [
        'NZS\Wampiriada\Checkins\CheckinActivityClass',
        'NZS\Wampiriada\Checkins\FirstTimeDonatingActivityClass',
        'NZS\Wampiriada\Checkins\Prize\PrizeForCheckinClaimedActivityClass',
        'NZS\Wampiriada\Checkins\Prize\PrizeForCheckinActivityClass',
        'NZS\Wampiriada\Reminders\ReminderActivityClass',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkins', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
            $table->dropColumn(['qualified_for_raffle', 'activity_id']);
        });

        Schema::table('checkin_prizes', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
            $table->dropColumn(['activity_id']);
        });

        Schema::table('wampiriada_reminders', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
            $table->dropColumn(['activity_id']);
        });

        foreach($this->classes as $class) {
            DB::table('activities')
                ->whereClassName($class)
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new Exception("This cannot be migrated back");
    }
}
