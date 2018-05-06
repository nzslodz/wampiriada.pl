<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;
use GuzzleHttp\Client;
use Facebook\GraphNodes\GraphUser;

use Illuminate\Notifications\Notifiable;

class Donor extends Model {
    use SyncableGraphNodeTrait;
    use Notifiable;

    protected $table = 'wampiriada_donors';

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
}
