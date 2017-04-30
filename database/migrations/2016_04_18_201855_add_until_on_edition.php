<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;
use NZS\Wampiriada\Editions\Edition;

class AddUntilOnEdition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $editions = [];
        foreach(Edition::all() as $edition) {
            $editions[$edition->id] = explode('/', $edition->when);
        }

        Schema::table('editions', function (Blueprint $table) {
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->dropColumn('when');
        });

        foreach(Edition::all() as $edition) {
            $year = $editions[$edition->id][1];
            $month = $editions[$edition->id][0];

            $edition->start_date = "$year-$month-01";
            $month++;
            $edition->end_date = "$year-$month-30";
            $edition->save();
        }

        Schema::table('editions', function(Blueprint $table) {
            $table->date('start_date')->change();
            $table->date('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $editions = [];
        foreach(Edition::all() as $edition) {
            $editions[$edition->id] = new Carbon($edition->start_date);
        }
        
        Schema::table('editions', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);

            $table->string('when');
        });

        foreach(Edition::all() as $edition) {
            $edition->when = "{$editions[$edition->id]->month}/{$editions[$edition->id]->year}";
            $edition->save();
        }
    }
}
