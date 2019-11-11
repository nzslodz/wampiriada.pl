<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Storage;
use Facebook\GraphNodes\GraphUser;
use NZS\Core\HasProfilePhoto;
use NZS\Wampiriada\Checkins\Checkin;

use Illuminate\Notifications\Notifiable;

class Donor extends Model {
    use Notifiable;
    use HasProfilePhoto;

    protected $table = 'wampiriada_donors';

    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

    public function getFullName() {
        return "$this->first_name $this->last_name";
    }

    public function checkins() {
        return $this->hasMany(Checkin::class, 'user_id');
    }
}
