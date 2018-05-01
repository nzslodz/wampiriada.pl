<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Editions\EditionData;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\OverallResult;

class RemoveConnectionBetweenCheckinAndMedicalData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('edition_data', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('editions')->onDelete('cascade');

            $table->unsignedInteger('donated')->default(0);

            $table->unsignedInteger('first_time')->nullable()->default(0);
            $table->unsignedInteger('marrow')->nullable()->default(0);
            $table->unsignedInteger('registered')->nullable()->default(0);
        });


        Schema::table('action_data', function (Blueprint $table) {
            $table->unsignedInteger('donated')->default(0);

            $table->unsignedInteger('first_time')->nullable()->default(0);
            $table->unsignedInteger('marrow')->nullable()->default(0);
            $table->unsignedInteger('registered')->nullable()->default(0);
        });

        foreach(ActionData::all() as $action_data) {
            $action_data->marrow = NULL;

            $sum = Checkin::whereActionDayId($action_data->id)->sum('first_time');

            if($action_data->id > 225) {
                $action_data->first_time = $sum;
            } else {
                $action_data->first_time = ($sum == 0) ? NULL: $sum;
            }

            $action_data->registered = NULL;
            $action_data->donated = $action_data->getOverall();

            $action_data->save();
        }

        foreach(Edition::all() as $edition) {
            $data = new EditionData;
            $data->id = $edition->id;

            $sum = Checkin::whereEditionId($edition->id)->sum('first_time');
            $data->first_time = ($sum == 0) ? NULL: $sum;

            $data->marrow = NULL;

            $data->registered = NULL;
            $data->donated = OverallResult::where('year', $edition->getStartDate()->year)->whereEditionType(floor($edition->getStartDate()->month / 6) + 1)->first()->overall;

            $data->save();
        }

        Schema::table('checkins', function(Blueprint $table) {
            $table->dropForeign(['blood_type_id']);
            $table->dropColumn(['first_time', 'blood_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
