<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Str;

use Storage;
use NZS\Wampiriada\Donor;

// XXX refactor
class PersonNewspaper extends Model {
    protected $table = 'wampiriada_promo_newspapers';

    public function user() {
        return $this->belongsTo(Donor::class, 'id');
    }

    public function generateFilename() {
        if(!$this->filename) {
            $this->filename = Str::random(32);
        }

        return $this->filename;
    }

    public function getImagePath() {
        $publicStorage = Storage::disk('public');

        if($publicStorage->has("newspaper-images/image_$this->filename.jpg")) {
            return "newspaper-images/image_$this->filename.jpg";
        }

        return null;
    }

    public function getArticleName() {

    }
}
