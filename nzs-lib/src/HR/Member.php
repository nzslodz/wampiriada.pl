<?php

namespace NZS\Core\HR;

use Illuminate\Database\Eloquent\Model as Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Storage;
use NZS\Core\Person;

use Illuminate\Notifications\Notifiable;

class Member extends Model {
    protected $table = 'hr_profiles';

    protected $dates = ['created_at', 'updated_at', 'member_since', 'member_to'];

    protected static $statuses = [
        'active_member' => 'Aktywny członek',
        'inactive_member' => 'Nieaktywny członek',
        'wellwisher' => 'Sympatyk',
        'alumnus' => 'Alumn',
    ];

    public static function getStatuses() {
        return array_keys(static::$statuses);
    }

    public static function getStatusesAsChoices() {
        return static::$statuses;
    }

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }
}
