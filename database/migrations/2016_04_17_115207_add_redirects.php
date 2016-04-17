<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use NZS\Wampiriada\Edition;
use NZS\Wampiriada\Redirect;

class AddRedirects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('edition_id')->unsigned()->nullable();
            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
            
            $table->string('key');
            $table->string('url');
        });

        $edition_26 = Edition::whereNumber(26)->first();
        $edition_27 = Edition::whereNumber(27)->first();

        Redirect::create(['key' => 'facebook-nzs', 'url' => 'http://facebook.com/NZSRegionuLodzkiego']);
        Redirect::create(['key' => 'facebook', 'url' => 'http://facebook.com/wampiriada.nzs.rl']);
        Redirect::create(['key' => 'nzs', 'url' => 'http://nzs.lodz.pl']);
        Redirect::create(['key' => 'przyjacielwampira', 'url' => 'https://www.facebook.com/hashtag/przyjacielwampira']);
        Redirect::create(['key' => 'twitter-nzs', 'url' => 'https://twitter.com/nzslodz/with_replies']);
        Redirect::create(['key' => 'facebook-event', 'url' => 'https://www.facebook.com/events/959790614053679/', 'edition_id' => $edition_26->id]);
        Redirect::create(['key' => 'koszulka', 'url' => 'https://www.facebook.com/wampiriada.nzs.rl/photos/a.119841281459933.20746.110146435762751/765979013512820/?type=1&theater', 'edition_id' => $edition_26->id]);
        Redirect::create(['key' => 'plakat', 'url' => 'https://www.facebook.com/NZSRegionuLodzkiego/photos/a.165034606884513.46602.150737411647566/842944849093482/?type=1&theater', 'edition_id' => $edition_26->id]);
        Redirect::create(['key' => 'facebook-event', 'url' => 'https://web.facebook.com/events/1653741798234348/', 'edition_id' => $edition_27->id]);
        Redirect::create(['key' => 'koszulka', 'url' => 'https://web.facebook.com/wampiriada.nzs.rl/photos/a.119841281459933.20746.110146435762751/852193724891348/?type=3&theater', 'edition_id' => $edition_27->id]);
        Redirect::create(['key' => 'plakat', 'url' => 'https://www.facebook.com/NZSRegionuLodzkiego/photos/a.165034606884513.46602.150737411647566/921727751215191/?type=3&theater', 'edition_id' => $edition_27->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('redirects');
    }
}
