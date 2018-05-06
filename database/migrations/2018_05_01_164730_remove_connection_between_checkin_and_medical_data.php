<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;

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

        foreach(DB::table('action_data')->get() as $action_data) {
            $updates = [
                'marrow' => null,
                'registered' => null,
                'donated' => $action_data->zero_plus
                    + $action_data->zero_minus
                    + $action_data->a_plus
                    + $action_data->a_minus
                    + $action_data->b_plus
                    + $action_data->b_minus
                    + $action_data->ab_plus
                    + $action_data->ab_minus
                    + $action_data->unknown,
            ];

            $sum = DB::table('checkins')
                ->where('action_day_id', $action_data->id)
                ->sum('first_time');

            if($action_data->id > 225) {
                $updates['first_time'] = $sum;
            } else {
                $updates['first_time'] = ($sum == 0) ? NULL: $sum;
            }

            DB::table('action_data')
                ->where('id', $action_data->id)
                ->update($updates);
        }

        foreach(DB::table('editions')->get() as $edition) {
            $sum = DB::table('checkins')
                ->where('edition_id', $edition->id)
                ->sum('first_time');

            $start_date = new Carbon($edition->start_date);

            $overall_result = DB::table('overall_results')
                ->where('year', $start_date->year)
                ->whereEditionType(floor($start_date->month / 6) + 1)
                ->first();

            DB::table('edition_data')->insert([
                'id' => $edition->id,
                'first_time' => ($sum == 0) ? NULL: $sum,
                'marrow' => null,
                'registered' => null,
                'donated' => $overall_result ? $overall_result->overall : 0,
            ]);
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
