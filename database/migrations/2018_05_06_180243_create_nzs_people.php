<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNzsPeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nzs_people', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->bigInteger('facebook_user_id')->unsigned()->nullable();

            $table->string('gender')->nullable();
            $table->decimal('gender_probability', 4, 2)->default(0);

            $table->string('email');

            $table->string('first_name');
            $table->string('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nzs_people');
    }
}
