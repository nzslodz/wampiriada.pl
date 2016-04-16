<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class Checkin extends Model {
    public function actionDay() {
        return $this->belongsTo(ActionDay::class);
    }
    
    public function edition() {
        return $this->belongsTo(Edition::class);
    }
}
