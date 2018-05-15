<?php namespace NZS\Wampiriada\Checkins;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Core\Person;
use NZS\Wampiriada\Checkins\Friend\FriendCheckin;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;

use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\BloodType;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\Editions\Edition;

class Checkin extends Model {
    public function actionDay() {
        return $this->belongsTo(ActionDay::class);
    }

    public function edition() {
        return $this->belongsTo(Edition::class);
    }

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function blood_type() {
        return $this->belongsTo(BloodType::class);
    }

    public function size() {
        return $this->belongsTo(ShirtSize::class);
    }

    public function prize() {
        return $this->hasOne(PrizeForCheckin::class);
    }

    public function friend_checkins() {
        return $this->hasMany(FriendCheckin::class);
    }
}
