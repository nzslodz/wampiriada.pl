<?php

namespace NZS\Core\HR;

use Illuminate\Database\Eloquent\Model as Model;
use Storage;
use NZS\Core\Person;
use NZS\Core\HR\MemberPresenter;
use Laracodes\Presenter\Traits\Presentable;


use Illuminate\Notifications\Notifiable;

class Member extends Model {
    use Presentable;

    protected $table = 'hr_profiles';

    protected $dates = ['created_at', 'updated_at', 'member_since', 'member_to'];

    protected $presenter = MemberPresenter::class;

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

    public function getStatus() {
        return static::getStatusesAsChoices()[$this->status];
    }

    public function user() {
        return $this->belongsTo(Person::class, 'id');
    }
}
