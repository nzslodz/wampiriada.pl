<?php namespace App\Http\Controllers;

use NZS\Core\CollectionAggregator;
use NZS\Core\Mailing\MailingManager;
use NZS\Core\Mailing\MailingRepository;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;
use NZS\Wampiriada\FacebookConncection;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinActivityClass;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinClaimedActivityClass;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\PrizeType;
use NZS\Wampiriada\Redirect;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Requests\PrizeTypeRequest;
use App\Http\Requests\PrizeForCheckinRequest;

use Auth;

class NewsletterController extends Controller {
	public function getRemove(Request $request) {
		

		/*$class_name = $request->input('class');
		if(!$repository->exists($class_name)) {
			return abort(404);
		}

		$composer = $class_name::spawnSampleInstance();

		$mailingManager = app(MailingManager::class);
		$mailingManager->setInPreviewMode();

		return view($composer->getView(), $composer->getSampleContext(Auth::user()->person));*/
	}

	public function postRemove(Request $request) {
		/*$class_name = $request->input('class');
		if(!$repository->exists($class_name)) {
			return abort(404);
		}

		$composer = $class_name::spawnSampleInstance();

		return view('admin.mailing.show', [
			'composer' => $composer,
			'class_name' => $class_name,
			'user' => Auth::user()->person,
		]);*/
	}

	public function getRemoveSuccess() {
		return view('');
	}
}
