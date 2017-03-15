<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;
use NZS\Core\ApplicationUser;

use Illuminate\Notifications\Notifiable;

class Person extends Model {
    use SyncableGraphNodeTrait;
    use Notifiable;

    protected $table = 'people';

    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

    protected static $graph_node_field_aliases = [
        'id' => 'facebook_user_id',
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

    public function application_user() {
        return $this->hasOne(ApplicationUser::class, 'id');
    }

    // XXX hack
    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            if(!$model->campaign_token) {
                $model->campaign_token = md5($model->email);
            }
        });
    }
}
