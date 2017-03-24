<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Core\Person;

class AddGenderFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->decimal('gender_probability', 4, 2)->default(0);
        });

        foreach(Person::all() as $person) {
            // XXX: update gender
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn(['gender', 'gender_probability']);
        });
    }
}
