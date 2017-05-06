<?php namespace NZS\Wampiriada\Mailing\Campaigns;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Core\Person;
use NZS\Core\Redirects\Redirect;

class EmailCampaignResult extends Model {
    public $fillable = ['campaign_id', 'user_id', 'redirect_id'];

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function campaign() {
        return $this->belongsTo(EmailCampaign::class);
    }

    public function redirect() {
        return $this->belongsTo(Redirect::class);
    }
}
