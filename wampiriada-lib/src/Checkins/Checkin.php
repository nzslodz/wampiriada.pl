<?php namespace NZS\Wampiriada\Checkins;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;

use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Donor;

class Checkin extends Model {
    public function actionDay() {
        return $this->belongsTo(ActionDay::class);
    }

    public function edition() {
        return $this->belongsTo(Edition::class);
    }

    public function user() {
        return $this->belongsTo(Donor::class, 'user_id');
    }

    public function size() {
        return $this->belongsTo(ShirtSize::class);
    }

    public function prize() {
        return $this->hasOne(PrizeForCheckin::class);
    }
}
