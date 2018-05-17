<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameWampiriadaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     protected $renames = [
         'action_data' => 'wampiriada_action_data',
         'action_days' => 'wampiriada_action_meta',
         'blood_types' => 'wampiriada_bloodtypes',
         'checkin_prize_items' => 'wampiriada_checkin_prize_items',
         'checkin_prizes' => 'wampiriada_checkin_prizes',
         'checkins' => 'wampiriada_checkins',
         'edition_configurations' => 'wampiriada_edition_meta',
         'edition_data' => 'wampiriada_edition_data',
         'editions' => 'wampiriada_editions',
         'person_newspapers' => 'wampiriada_promo_newspapers',
         'places' => 'wampiriada_action_places',
         'prize_types' => 'wampiriada_prizetypes',
         'schools' => 'wampiriada_universities',
         'shirt_sizes' => 'wampiriada_shirtsizes',
    ];

    public function up()
    {
        foreach($this->renames as $key => $value) {
            Schema::rename($key, $value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->renames as $key => $value) {
            Schema::rename($value, $key);
        }
    }
}
