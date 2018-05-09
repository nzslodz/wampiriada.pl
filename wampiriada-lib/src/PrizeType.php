<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

// XXX make it edition-dependant?
class PrizeType extends Model {
    protected $table = 'wampiriada_prizetypes';

    protected $casts = [
        'active' => 'boolean',
    ];
}
