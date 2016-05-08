<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHiddenActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_days', function (Blueprint $table) {
            $table->boolean('hidden')->default(false);
        });

        DB::statement('DROP VIEW IF EXISTS actions');
        DB::statement('CREATE VIEW `actions` 
            AS SELECT
                `action_days`.`id` AS `id`,
                `action_days`.`created_at` AS `day`,
                `action_days`.`start` AS `start`,
                `action_days`.`end` AS `end`,
                `action_days`.`marrow` AS `marrow`,
                `action_days`.`hidden` AS `hidden`,
                `places`.`name` AS `place`,
                `schools`.`short_name` AS `school_short`,
                `schools`.`name` AS `school`,
                `places`.`address` AS `address`,
                `places`.`lat` AS `lat`,
                `places`.`lng` AS `lng`,
                `editions`.`number` AS `number`,
                `action_days`.`gallery_image` AS `gallery_image`,
                `action_days`.`gallery_link` AS `gallery_link`
            FROM `action_days` 
            join `places` on `action_days`.`place_id` = `places`.`id` 
            join `schools` on `places`.`school_id` = `schools`.`id` 
            join `editions` on`action_days`.`edition_id` = `editions`.`id`
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_days', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
        
        DB::statement('DROP VIEW IF EXISTS actions');
        DB::statement('CREATE VIEW `actions` 
            AS SELECT
                `action_days`.`id` AS `id`,
                `action_days`.`created_at` AS `day`,
                `action_days`.`start` AS `start`,
                `action_days`.`end` AS `end`,
                `action_days`.`marrow` AS `marrow`,
                `places`.`name` AS `place`,
                `schools`.`short_name` AS `school_short`,
                `schools`.`name` AS `school`,
                `places`.`address` AS `address`,
                `places`.`lat` AS `lat`,
                `places`.`lng` AS `lng`,
                `editions`.`number` AS `number`,
                `action_days`.`gallery_image` AS `gallery_image`,
                `action_days`.`gallery_link` AS `gallery_link`
            FROM `action_days` 
            join `places` on `action_days`.`place_id` = `places`.`id` 
            join `schools` on `places`.`school_id` = `schools`.`id` 
            join `editions` on`action_days`.`edition_id` = `editions`.`id`
        ');
    }
}
