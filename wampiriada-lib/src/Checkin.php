<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use App\User;


class Checkin extends Model {
    public function actionDay() {
        return $this->belongsTo(ActionDay::class);
    }

    public function edition() {
        return $this->belongsTo(Edition::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function blood_type() {
        return $this->belongsTo(BloodType::class);
    }

    public function size() {
        return $this->belongsTo(ShirtSize::class);
    }
}
