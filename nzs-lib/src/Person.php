<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;
use GuzzleHttp\Client;
use Facebook\GraphNodes\GraphUser;
use NZS\Core\ApplicationUser;

use Illuminate\Notifications\Notifiable;

class Person extends Model {
    use SyncableGraphNodeTrait;
    use Notifiable;

    protected $table = 'people';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'gender',
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

    public function updateGender($something=null) {
        // raw input - e.g. from form
        if($something == 'male' || $something == 'female') {
            $this->gender = $something;
            $this->gender_probability = 1;

            return;
        }

        // for facebook GraphNodes
        if(method_exists($something, 'getField')) {
            $gender = $something->getField('gender');
            if($gender) {
                $this->gender = $gender;
                $this->gender_probability = 1;

                return;
            }
        }

        // try to find by first_name
        if($this->first_name) {
            $guzzle = new Client();

            $res = $client->request('GET', 'https://api.genderize.io/', [
                'query' => ['name' => $this->first_name, 'country_id' => 'pl'],
            ]);

            if($res->getStatusCode() == 200) {
                $json = json_decode($res->getBody());

                if($json['gender']) {
                    $this->gender = $json['gender'];
                    $this->gender_probability = $json['probability'];

                    return;
                }
            }

            if(ends_with($this->first_name, 'a')) {
                $this->gender = 'female';
                $this->gender_probability = 0.01;
            } else {
                $this->gender = 'male';
                $this->gender_probability = 0.01;
            }

            return;
        }
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
