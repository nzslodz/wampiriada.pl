<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;
use NZS\Core\Person;

class MigrateUsersToPeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // basically, divide user database into two tables -> Person(id, email, created_at, updated_at, facebook_user_id, first_name, last_name, md5email)

        foreach (User::all() as $user) {
            $person = new Person;
            $person->id = $user->id;
            $person->email = $user->email;
            $person->created_at = $user->created_at;
            $person->updated_at = $user->updated_at;
            if($user->facebook_user_id > 0) {
                $person->facebook_user_id = $user->facebook_user_id;
            }

            $person->first_name = $user->first_name;
            $person->last_name = $user->last_name;
            $person->campaign_token = $user->md5email;
            $person->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Person::truncate();
    }
}
