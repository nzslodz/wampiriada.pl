<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveEmailCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('email_campaign_results');
        Schema::drop('email_campaigns');

        DB::table('activities')
            ->whereClassName('NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResultActivityClass')
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
