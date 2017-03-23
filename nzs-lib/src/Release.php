<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Notifications\Notifiable;
use NZS\Core\CardMetadata;

class Release extends Model {
    protected $table = 'trello_releases';

    public function cards() {
        return $this->hasMany(CardMetadata::class, 'release_id');
    }
}
