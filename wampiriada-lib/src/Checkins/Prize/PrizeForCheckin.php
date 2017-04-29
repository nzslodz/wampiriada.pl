<?php namespace NZS\Wampiriada\Checkins\Prize;

use Illuminate\Database\Eloquent\Model as Model;

use Carbon\Carbon;

use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\PrizeType;

class PrizeForCheckin extends Model {
    protected $table = 'checkin_prizes';

    protected $dates = ['created_at', 'updated_at', 'claimed_at'];

    protected $fillable = ['checkin_id'];

    public function checkin() {
        return $this->belongsTo(Checkin::class);
    }

    public function items() {
        return $this->belongsToMany(PrizeType::class, 'checkin_prize_items', 'checkin_prize_id', 'prize_type_id');
    }

    public function getTimeDiffUntilClaimed() {
        if(!$this->claimed_at) {
            return false;
        }

        Carbon::setLocale('pl');

        if($this->claimed_at->diffInMinutes($this->created_at) < 10) {
            return 'Nagroda wpisana po odbiorze';
        }

        return $this->created_at->diffForHumans($this->claimed_at);
    }
}
