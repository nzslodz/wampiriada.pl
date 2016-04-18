<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;

class Edition extends Model {
	protected $table = 'editions';

    public $timestamps = false;

    public function getStartDate() {
        return new Carbon($this->start_date);
    }

    public function getEndDate() {
        return new Carbon($this->end_date);
    }
}
