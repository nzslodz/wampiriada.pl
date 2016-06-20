<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\FacebookConnection;

class FriendCheckin extends Model {
    public $timestamps = false;

    public function checkin() {
        return $this->belongsTo(Checkin::class);
    }

    public function friend_checkin() {
        return $this->belongsTo(Checkin::class, 'friend_checkin_id');
    }

    public function facebook_connection() {
        return $this->belongsTo(FacebookConnection::class);
    }
}
