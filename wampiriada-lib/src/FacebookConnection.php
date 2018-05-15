<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;

class FacebookConnection extends Model {
	public $timestamps = false;

	public $fillable = ['source_id', 'target_id'];
}