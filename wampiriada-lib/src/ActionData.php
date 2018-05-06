<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\ActionDay;

class ActionData extends Model {
    protected $table = 'action_data';

    public $fillable = ['id'];

    public $timestamps = false;

    public function getOverallAttribute() {
        return $this->zero_plus
            + $this->zero_minus
            + $this->a_plus
            + $this->a_minus
            + $this->b_plus
            + $this->b_minus
            + $this->ab_plus
            + $this->ab_minus
            + $this->unknown;
    }

    public function getFirstTimePercentage() {
        return round(100 * $this->first_time / $this->donated);
    }

    public function action_day() {
        return $this->belongsTo(ActionDay::class, 'id');
    }
}
