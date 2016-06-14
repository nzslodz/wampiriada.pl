<?php namespace App\Http\Controllers;

use NZS\Core\CollectionAggregator;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\FacebookConncection;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\Redirect;
use NZS\Core\Contracts\Timeline;
use DB;

use NZS\Core\Activity;

use App\User;

use Illuminate\Http\Request;

class ActivityController extends Controller {
    public function getProfile(User $user) {
        $activities = Activity::whereUserId($user->id)->orderBy('created_at')->get();

        $json = [];
        foreach($activities as $activity) {
            $json[] = $activity->resolveInterface(Timeline::class)->convertToTimelineObject();
        }

        return view('admin.activity.profile', [
            'timeline_json' => ['events' => $json],
            'activities' => $activities,
            'user' => $user,
        ]);
    }

}
