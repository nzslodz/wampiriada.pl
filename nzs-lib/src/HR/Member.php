<?php

namespace NZS\Core\HR;

use Illuminate\Database\Eloquent\Model as Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;
use NZS\Core\Person;

use Illuminate\Notifications\Notifiable;

class Member extends Model {
    protected $table = 'hr_profiles';

    protected $dates = ['created_at', 'updated_at', 'member_since', 'member_to'];

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }
}
