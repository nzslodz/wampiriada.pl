<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use App\User;
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
}
