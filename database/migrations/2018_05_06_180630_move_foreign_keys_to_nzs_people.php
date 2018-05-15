<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveForeignKeysToNzsPeople extends Migration
{
    protected $tables = [
        'activities' => 'user_id',
        'poll_answers' => 'user_id',
        'users' => 'id',
        'nzs_attendances' => 'user_id',
        'hr_profiles' => 'id',
        'hr_achievements' => 'user_id',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // copy required items to nzs_people table
        foreach($this->tables as $table => $field) {
            foreach(DB::table($table)->get() as $model) {
                $id = $model->$field;

                if(DB::table('nzs_people')->where('id', $id)->first()) {
                    continue;
                }

                $person = DB::table('people')->where('id', $id)->first();

                DB::table('nzs_people')->insert([
                    'id' => $person->id,
                    'email' => $person->email,
                    'created_at' => $person->created_at,
                    'updated_at' => $person->updated_at,
                    'last_name' => $person->last_name,
                    'first_name' => $person->first_name,
                    'facebook_user_id' => $person->facebook_user_id,
                    'gender' => $person->gender,
                    'gender_probability' => $person->gender_probability,
                ]);
            }
        }

        foreach($this->tables as $table => $field) {
            Schema::table($table, function(Blueprint $table) use($field) {
                $table->dropForeign([$field]);
                $table->foreign($field)->references('id')->on('nzs_people');
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
                $table->foreign($field)->references('id')->on('people');
            });
        }
    }
}
