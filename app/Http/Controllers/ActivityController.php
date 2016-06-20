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
use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Exceptions\CannotResolveInterface;

use App\User;
use Storage;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ActivityController extends Controller {
    public function getProfile(User $user) {
        $activities = Activity::whereUserId($user->id)->orderBy('created_at')->get();

        $json = [];
        foreach($activities as $activity) {
            try {
                $json[] = $activity->resolveInterface(Timeline::class)->convertToTimelineObject();
            } catch(CannotResolveInterface $e) {
                // object should not be shown in timeline
            }
        }

        return view('admin.activity.profile', [
            'timeline_json' => ['events' => $json],
            'activities' => $activities,
            'timeline_activity_count' => count($json),
            'user' => $user,
        ]);
    }

    public function getProfileCard(User $user) {
        $activity_count = Activity::whereUserId($user->id)->count();

        if($user->facebook_user_id) {
            try {
                $storage = Storage::disk('local');
                $contents = $storage->get("fb-images/$user->facebook_user_id.jpg");

                $image = "data:image/jpeg;base64,". base64_encode($contents);
            } catch(FileNotFoundException $e) {
                $image = null;
            }
        } else {
            $image = null;
        }

        return view('admin.activity.card', [
            'user' => $user,
            'activity_count' => $activity_count,
            'image' => $image,
        ]);
    }

}
