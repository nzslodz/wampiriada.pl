<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

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
            DB::table('people')->insert([
                'id' => $user->id,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'facebook_user_id' => $user->facebook_user_id ? $user->facebook_user_id: null,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'campaign_token' => $user->campaign_token,
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
        DB::table('people')->truncate();
    }
}
