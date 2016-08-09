<?php namespace NZS\Core\Polls;

use Illuminate\Database\Eloquent\Model as Model;

class Answer extends Model {
    protected $table = 'poll_answers';

    public function getSanitizedData() {
        return collect($this->raw_answer);
    }

    protected $casts = [
        'raw_answer' => 'array',
    ];
}
