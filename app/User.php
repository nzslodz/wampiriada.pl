<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use NZS\Core\Person;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function person() {
        return $this->belongsTo(Person::class, 'id');
    }

    public function getFullName() {
        return $this->person->getFullName();
    }
}
