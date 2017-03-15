<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateForeignKeys extends Migration
{
    protected $tables = [
        'activities' => 'user_id',
        'checkins' => 'user_id',
        'email_campaign_results' => 'user_id',
        'poll_answers' => 'user_id',
        'wampiriada_profile' => 'id',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->tables as $table => $field) {
            Schema::table($table, function(Blueprint $table) use($field) {
                $table->dropForeign([$field]);
                $table->foreign($field)->references('id')->on('people');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->tables as $table => $field) {
            Schema::table($table, function(Blueprint $table) use($field) {
                $table->dropForeign([$field]);
                $table->foreign($field)->references('id')->on('users');
            });
        }
    }
}
