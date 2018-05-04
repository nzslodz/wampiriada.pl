<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use NZS\Wampiriada\Migration\Models\BloodType;
use NZS\Wampiriada\ShirtSize;

class AddCheckinTables extends Migration {
    protected $blood_types = [
        'a_plus' => 'A+',
        'a_minus' => 'A-',
        'b_plus' => 'B+',
        'b_minus' => 'B-',
        'ab_plus' => 'AB+',
        'ab_minus' => 'AB-',
        'zero_plus' => '0+',
        'zero_minus' => '0-',
        'unknown' => 'Nie wiem',
    ];

    protected $shirt_sizes = [ 'XS', 'S', 'M', 'L', 'XL', 'XXL' ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement('ALTER TABLE users ENGINE=InnoDB');

        Schema::create('blood_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('name');
        });

        foreach($this->blood_types as $key => $name) {
            $blood_type = new BloodType();

            $blood_type->key = $key;
            $blood_type->name = $name;

            $blood_type->save();
        }

        Schema::create('shirt_sizes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('active')->default(true);
        });

        foreach($this->shirt_sizes as $size_name) {
            $size = new ShirtSize();

            $size->name = $size_name;
            $size->active = true;

            $size->save();
        }

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

        Schema::create('checkins', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->boolean('first_time')->default(false);
            $table->timestamps();

            $table->integer('size_id')->unsigned();
            $table->foreign('size_id')->references('id')->on('shirt_sizes');

            $table->integer('blood_type_id')->unsigned();
            $table->foreign('blood_type_id')->references('id')->on('blood_types');

            $table->string('name');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('checkins');
        Schema::drop('wampiriada_profile');
        Schema::drop('shirt_sizes');
        Schema::drop('blood_types');
    }
}
