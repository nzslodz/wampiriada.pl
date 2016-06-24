<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Wampiriada\Checkin;

class Edition extends Model {
	protected $table = 'editions';
    protected $repository = null;

    public $timestamps = false;

    public static function current() {
        $number = Option::get('wampiriada.edition', 28);

        return static::whereNumber($number)->first();
    }

    public function getStartDate() {
        return new Carbon($this->start_date);
    }

    public function getEndDate() {
        return new Carbon($this->end_date);
    }

    public function getRepository() {
        if(!$this->repository) {
            $this->repository = new EditionRepository($this);
        }

        return $this->repository;
    }

	public function checkins() {
		return $this->hasMany(Checkin::class);
	}
}
