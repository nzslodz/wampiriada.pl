<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Core\Redirects\Redirect;
use NZS\Wampiriada\Redirects\WampiriadaRedirect;

class ExtractEditionIdFromRedirectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wampiriada_redirects', function(Blueprint $table) {
            $table->integer('redirect_id')->unsigned();
            $table->foreign('redirect_id')->references('id')->on('redirects')->onDelete('cascade');

            $table->integer('edition_id')->unsigned();
            $table->foreign('edition_id')->references('id')->on('editions');

            $table->primary(['redirect_id', 'edition_id']);
        });

        foreach(Redirect::all() as $redirect) {
            if(!$redirect->edition_id) {
                continue;
            }

            WampiriadaRedirect::create([
                'edition_id' => $redirect->edition_id,
                'redirect_id' => $redirect->id,
            ]);
        }

        Schema::table('redirects', function(Blueprint $table) {
            $table->dropForeign(['edition_id']);
            $table->dropColumn('edition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redirects', function(Blueprint $table) {
            $table->integer('edition_id')->unsigned()->nullable();
            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
        });

        foreach(WampiriadaRedirect::all() as $wampiriada_redirect) {
            $redirect = $wampiriada_redirect->redirect;

            $redirect->edition_id = $wampiriada_redirect->edition_id;
            $redirect->save();
        }

        Schema::drop('wampiriada_redirects');
    }
}
