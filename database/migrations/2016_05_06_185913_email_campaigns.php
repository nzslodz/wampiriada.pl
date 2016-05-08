<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

class EmailCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('key');
        });
        
        Schema::create('email_campaign_results', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->integer('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('email_campaigns');
            
            $table->integer('redirect_id')->unsigned();
            $table->foreign('redirect_id')->references('id')->on('redirects');

            $table->unique(['user_id', 'campaign_id', 'redirect_id']);
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('md5email')->nullable();
        });

        foreach(User::all() as $user) {
            $user->md5email = md5($user->email);
            $user->save();
        }

        Schema::table('users', function(Blueprint $table) {
            $table->string('md5email')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('email_campaign_results');
        Schema::drop('email_campaigns');

        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('md5email');
        });
    }
}
