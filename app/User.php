<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;

class User extends Authenticatable {
    use SyncableGraphNodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected static $graph_node_field_aliases = [
        'id' => 'facebook_user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullName() {
        return "$this->first_name $this->last_name";
    }

    public function getFacebookProfileImagePath() {
        if($this->facebook_user_id && Storage::has("fb-images/$this->facebook_user_id.jpg")) {
            return "fb-images/$this->facebook_user_id.jpg";
        }

        $image_id = crc32($this->facebook_user_id . $this->email) % 32;

        return "default-images/$image_id.png";
    }

    // XXX hack
    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->md5email = md5($model->email);
        });
    }
}
