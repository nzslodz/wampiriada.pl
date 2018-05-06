<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class PrizeType extends Model {
    protected $table = 'wampiriada_prizetypes';

    protected $casts = [
        'active' => 'boolean',
    ];
}
