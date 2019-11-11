<?php namespace App\Http\Controllers;

use Session;
use App\Http\Requests\CheckinRequest;
use App\Http\Requests\EmailLoginRequest;
use Illuminate\Http\Request;

use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\BloodType;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Editions\EditionRepository;
use Carbon\Carbon;

use App\Jobs\DownloadFacebookProfile;
use App\Jobs\RegenerateTileImage;

use NZS\Wampiriada\Mailing\WampiriadaThankYouMailingComposer;
use NZS\Wampiriada\Donor;

use App\Libraries\ErrorMailer;
use LogicException;
use Mail;
use DB;
use App;

use Storage;

class CheckinController extends Controller {
    public function getPrivacyPolicy() {
        return view('facebook.privacy_policy');
    }

    public function getLoginPage(Request $request, EditionRepository $repository) {
        if(!$repository->currentAction()) {
            return view('facebook.login_forbidden');
        }

        $shirt_sizes = ShirtSize::orderBy('id')
            ->where('active', true)
            ->pluck('name', 'id');

        return view('facebook.login', [
            'sizes' => $shirt_sizes,
        ]);
    }

    public function postCheckin(CheckinRequest $request, EditionRepository $repository) {
        if(!$repository->currentAction()) {
            return response()->json([
                'status' => 'forbidden',
                'str_code' => 'CHECKIN_NOT_AVAILABLE',
                'message' => 'Today the checkin process is not available'
            ], 403);
        }

        $user = $request->getDonor();

        if($user && $user->id) {
            $checkin = Checkin::whereUserId($user->id)
                ->whereEditionId($repository->getEdition()->id)
                ->first();

            if($checkin && !app()->environment('local')) {
                return response()->json([
                    'status' => 'forbidden',
                    'str_code' => 'MULTIPLE_CHECKIN',
                    'message' => 'You cannot donate blood two times in the same edition'
                ], 403);
            }
        }

        DB::transaction(function() use($request, $user, $repository) {
            if($user) {
                $user->save();
            }

            $repository->checkin($user, $request);
        });

        if($user) {
            $composer = new WampiriadaThankYouMailingComposer($repository->getEdition());

            $job = $composer->getJobInstance($user);
            if(App::environment('production')) {
                $job->delay(Carbon::now()->addHours(2));
            }

            dispatch($job);
        }

        // XXX check this
        dispatch(new RegenerateTileImage());

        return response()->json([
            'status' => 'success',
        ]);
    }
}
