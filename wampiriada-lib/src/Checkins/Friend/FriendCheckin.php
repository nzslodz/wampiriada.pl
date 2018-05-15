<?php namespace NZS\Wampiriada\Checkins\Friend;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\FacebookConnection;

class FriendCheckin extends Model {
    public $timestamps = false;

    protected $fillable = ['facebook_connection_id', 'checkin_id', 'friend_checkin_id'];

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
