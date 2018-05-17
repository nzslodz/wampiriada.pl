<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Core\ApplicationUser;

class DeleteUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ApplicationUser::wherePassword('')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(DB::table('people')->all() as $person) {
            if(ApplicationUser::find($person->id)) {
                continue;
            }

            $user = new ApplicationUser;
            $user->id = $person->id;
            $user->email = $person->email;
            $user->username = $person->email;
            $user->confirmed = 0;
            $user->created_at = $person->created_at;
            $user->updated_at = $person->updated_at;
            $user->facebook_user_id = $person->facebook_user_id;
            $user->first_name = $person->first_name;
            $user->is_staff = 0;
            $user->md5email = $person->campaign_token;
            $user->save();
        }
    }
}
