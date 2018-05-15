<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class ActionData extends Model {
    protected $table = 'action_data';

    public $fillable = ['id'];

    public $timestamps = false;

    public function getOverall() {
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

    public function getOverallAttribute() {
        return $this->getOverall();
    }
}