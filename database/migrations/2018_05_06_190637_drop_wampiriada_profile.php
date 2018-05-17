<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropWampiriadaProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('wampiriada_profile');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('wampiriada_profile', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->string('current_name');

            $table->integer('default_size_id')->unsigned();
            $table->foreign('default_size_id')->references('id')->on('shirt_sizes');

            $table->integer('blood_type_id')->unsigned();
            $table->foreign('blood_type_id')->references('id')->on('blood_types');

            $table->primary('id');
        });
    }
}
