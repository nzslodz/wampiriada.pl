<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use NZS\Wampiriada\Checkins\Checkin;
use App\User;

class CleanSpacesFromCheckins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     protected function getNameAsPair($current_name) {
         $list = explode(' ', $current_name);

         if(count($list) != 2) {
             return [null, null];
         }

         return $list;
     }

    public function up()
    {
        foreach(Checkin::all() as $checkin) {
            $checkin->name = trim(preg_replace('/\s+/u', ' ', $checkin->name));
            $checkin->save();
        }

        foreach(DB::table('wampiriada_profile')->get() as $profile) {
            $current_name = trim(preg_replace('/\s+/u', ' ', $profile->current_name));

            DB::table('wampiriada_profile')
                ->where('id', $profile->id)
                ->update([
                    'current_name' => $current_name,
                ]);


            $user = DB::table('users')->where('id', $profile->id)->first();

            if($user->first_name || $user->last_name) {
                continue;
            }

            list($first_name, $last_name) = $this->getNameAsPair($profile->current_name);

            DB::table('users')
                ->where('id', $profile->id)
                ->update([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                ]);
        }
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
