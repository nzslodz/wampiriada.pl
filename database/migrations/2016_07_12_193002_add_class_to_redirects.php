<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Core\Redirects\Redirect;
use NZS\Core\Redirects\DatabaseRedirectRepository;
use NZS\Wampiriada\WampiriadaRedirectRepository;
use NZS\Wampiriada\WampiriadaRedirect;

class AddClassToRedirects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->string('class_name')->nullable();
        });

        foreach(Redirect::all() as $redirect) {
            if(WampiriadaRedirect::whereRedirectId($redirect->id)->first()) {
                $redirect->class_name = WampiriadaRedirectRepository::class;
            } else {
                $redirect->class_name = DatabaseRedirectRepository::class;
            }

            $redirect->save();
        }

        Schema::table('redirects', function (Blueprint $table) {
            $table->string('class_name')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->dropColumn('class_name');
        });
    }
}
