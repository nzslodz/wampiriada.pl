<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUsersFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'facebook_user_id', 'first_name', 'last_name', 'md5email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username');
            $table->bigInteger('facebook_user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('md5email');
        });
    }
}
