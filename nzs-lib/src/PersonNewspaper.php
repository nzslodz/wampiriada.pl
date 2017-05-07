<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;

use Storage;

class PersonNewspaper extends Model {
    protected $table = 'person_newspapers';

    public function user() {
        return $this->belongsTo(Person::class, 'id');
    }

    public function generateFilename() {
        if(!$this->filename) {
            $this->filename = str_random(32);
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
