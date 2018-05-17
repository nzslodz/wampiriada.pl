<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;
use NZS\Core\HasProfilePhoto;

use Illuminate\Notifications\Notifiable;
use NZS\Core\Person;

// XXX should be removed?
class User extends Authenticatable {
    use Notifiable;
    use HasProfilePhoto;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function person() {
        return $this->belongsTo(Person::class, 'id');
    }
}
