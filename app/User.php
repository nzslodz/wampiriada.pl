<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;
use NZS\Core\HasProfilePhoto;

use Illuminate\Notifications\Notifiable;

// XXX should be removed?
class User extends Authenticatable {
    use Notifiable;
    use HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullName() {
        return "$this->first_name $this->last_name";
    }
}
