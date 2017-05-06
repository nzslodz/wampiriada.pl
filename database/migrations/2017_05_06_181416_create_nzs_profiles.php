<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNzsProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_profiles', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('people')->onDelete('cascade');

            $table->timestamps();

            $table->string('status');

            $table->boolean('has_badge')->default(false);
            $table->boolean('is_member')->default(false);

            $table->dateTime('member_since')->nullable();
            $table->dateTime('member_to')->nullable();

            $table->primary('id');
        });

        Schema::create('nzs_events', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();

            $table->boolean('is_public')->default(false);

            $table->dateTime('happened_at');

            $table->string('name');
            $table->longText('description');
        });

        Schema::create('nzs_attendances', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('people')->onDelete('cascade');

            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('nzs_events')->onDelete('cascade');

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');

            $table->timestamps();

            $table->string('role');

            $table->dateTime('attended_since')->nullable();
            $table->dateTime('attended_to')->nullable();

            $table->longText('additional_notes')->nullable();
        });

        Schema::create('hr_achievement_types', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();

            $table->string('name');
            $table->longText('description')->nullable();
        });

        Schema::create('hr_achievements', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('people')->onDelete('cascade');

            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('hr_achievement_types')->onDelete('cascade');

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');

            $table->timestamps();

            $table->longText('additional_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_achievements');
        Schema::dropIfExists('hr_achievement_types');
        Schema::dropIfExists('nzs_attendances');

        Schema::dropIfExists('hr_profiles');
        Schema::dropIfExists('nzs_events');

    }
}
