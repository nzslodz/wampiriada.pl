<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Notifications\Notifiable;
use NZS\Core\CardMetadata;

class Board extends Model {
    protected $table = 'trello_boards';

    public function cards() {
        return $this->hasMany(CardMetadata::class, 'board_id');
    }
}
