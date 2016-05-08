<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use App\User;

class EmailCampaignResult extends Model {
    public $fillable = ['campaign_id', 'user_id', 'redirect_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function campaign() {
        return $this->belongsTo(EmailCampaign::class);
    }

    public function redirect() {
        return $this->belongsTo(Redirect::class);
    }
}
