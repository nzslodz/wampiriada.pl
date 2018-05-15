<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixUserModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // username drops
        // basically, divide user database into two tables -> Person(id, email, created_at, updated_at, facebook_user_id, first_name, last_name, md5email)

        // facebook_user_id = 0 => null
        // and ApplicationAccount (password, confirmation_code, confirmed, remember_token, is_staff, created_at, updated_at)
        // then rewrite the CheckinController not to use Auth::login on users
        // and rewrite the app to use new models and leave User only to migrations and so forth

        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('email');

            $table->bigInteger('facebook_user_id')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('last_name');

            $table->string('campaign_token');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('people');
    }
}
