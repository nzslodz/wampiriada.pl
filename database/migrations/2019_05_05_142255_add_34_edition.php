<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Wampiriada\Editions\EditionSchema;
use NZS\Wampiriada\Place;

class Add34Edition extends Migration
{

    protected
        $number = 34,
        $dates = [
            '2019-05-07',
            '2019-06-06'
        ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        EditionSchema::create($this->number, function($build) {
            // Create new place
            $place = new Place;

            $place->name = 'Uniwersytet Medyczny';
            $place->address = 'ul. Żeligowskiego 7/9, sala 247';
            $place->lat = '51.7714093';
            $place->lng = '19.437983';
            $place->school_id = 21;

            $place->save();

            // Build the edition
            $build->action("2019-05-07", 52)->hours(11, 16);
            $build->action("2019-05-08", 59);

            $build->action("2019-05-13", $place->id);
            $build->action("2019-05-14", 57);
            $build->action("2019-05-15", 65);
            $build->action("2019-05-16", 50);
            $build->action("2019-05-18", 61)->hours(10, 13);

            $build->action("2019-05-21", 56);
            $build->action("2019-05-23", 74)->hours(10, 15);
            $build->action("2019-05-27", 58)->hours(9, 15);
            $build->action("2019-05-28", 55);
            $build->action("2019-05-29", 52);

            $build->configure([
                'display_results' => false,
                'display_actions' => true,
                'display_faces' => false,
            ]);

        }, $this->dates);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EditionSchema::remove($this->number);
    }
}
