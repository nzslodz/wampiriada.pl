<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataProcessingAgreementFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wampiriada_donors', function (Blueprint $table) {
            $table->boolean('consent_email_wampiriada')->default(true);
            $table->boolean('consent_email_nzs')->default(true);
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
            $table->dropColumn([
                'consent_email_nzs',
                'consent_email_wampiriada',
            ]);
        });
    }
}
