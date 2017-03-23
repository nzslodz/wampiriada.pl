<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trello_releases', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('closed')->default(false);
            $table->string('trello_board_id');
            $table->string('trello_list_id');
            $table->string('name');
        });

        Schema::create('trello_boards', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('trello_board_id');
            $table->string('trello_board_name');
        });

        Schema::create('trello_card_metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('release_id')->unsigned();
            $table->foreign('release_id')->references('id')->on('trello_releases')->onDelete('cascade');

            $table->integer('original_board_id')->unsigned();
            $table->foreign('original_board_id')->references('id')->on('trello_boards')->onDelete('cascade');

            $table->string('trello_original_board_id');
            $table->string('trello_original_list_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trello_card_metadata');
        Schema::dropIfExists('trello_boards');
        Schema::dropIfExists('trello_releases');
    }
}
