<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Notifications\Notifiable;

class CardMetadata extends Model {
    protected $table = 'trello_card_metadata';

    public function release() {
        return $this->belongsTo(Release::class, 'release_id');
    }

    public function board() {
        return $this->belongsTo(Board::class, 'board_id');
    }
}
