<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\CheckinActivityClass;

use NZS\Wampiriada\EmailCampaignResultActivityClass;
use NZS\Wampiriada\EmailCampaignResult;

class AddActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function(Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');

          $table->increments('id');
          $table->timestamps();

          $table->string('class_name');
        });

        Schema::table('checkins', function(Blueprint $table) {
            $table->integer('activity_id')->unsigned()->nullable();
            $table->foreign('activity_id')->references('id')->on('activities');
        });

        $activity_class = new CheckinActivityClass;
        foreach(Checkin::all() as $checkin) {
            $activity = $activity_class->saveActivityInstance($checkin);
            $checkin->activity_id = $activity->id;
            $checkin->save();
        }

        Schema::table('checkins', function(Blueprint $table){
            $table->integer('activity_id')->unsigned()->change();
        });

        Schema::table('email_campaign_results', function(Blueprint $table) {
            $table->integer('activity_id')->unsigned()->nullable();
            $table->foreign('activity_id')->references('id')->on('activities');
        });

        $activity_class = new EmailCampaignResultActivityClass();
        foreach(EmailCampaignResult::all() as $result) {
            $activity = $activity_class->saveActivityInstance($result);
            $result->activity_id = $activity->id;
            $result->save();
        }

        Schema::table('email_campaign_results', function(Blueprint $table) {
            $table->integer('activity_id')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkins', function(Blueprint $table) {
            $table->dropForeign('checkins_activity_id_foreign');
            $table->dropColumn('activity_id');
        });

        Schema::table('email_campaign_results', function(Blueprint $table) {
            $table->dropForeign('email_campaign_results_activity_id_foreign');
            $table->dropColumn('activity_id');
        });

        Schema::drop('activities');
    }
}
