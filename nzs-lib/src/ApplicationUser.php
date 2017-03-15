<?php namespace NZS\Core;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

use Illuminate\Notifications\Notifiable;

class ApplicationUser extends Authenticatable {
    protected $table = 'users';

    protected $fillable = [
         'password', 'person_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function person() {
        return $this->belongsTo(Person::class, 'id');
    }
}
