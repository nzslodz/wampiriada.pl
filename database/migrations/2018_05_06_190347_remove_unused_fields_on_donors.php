<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedFieldsOnDonors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wampiriada_donors', function (Blueprint $table) {
            $table->dropColumn(['campaign_token', 'gender', 'gender_probability', 'disable_emails']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wampiriada_donors', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->decimal('gender_probability', 4, 2)->default(0);

            $table->boolean('disable_emails')->default(false);

            $table->string('campaign_token')->nullable();
        });
    }
}
