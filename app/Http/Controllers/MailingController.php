<?php namespace App\Http\Controllers;

use NZS\Core\CollectionAggregator;
use NZS\Core\Mailing\MailingManager;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\PrizeForCheckin;
use NZS\Wampiriada\FacebookConncection;
use NZS\Wampiriada\PrizeForCheckinActivityClass;
use NZS\Wampiriada\PrizeForCheckinClaimedActivityClass;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\PrizeType;
use NZS\Wampiriada\Redirect;
use DB;
use Carbon\Carbon;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\PrizeTypeRequest;
use App\Http\Requests\PrizeForCheckinRequest;
use NZS\Wampiriada\WampiriadaSummaryMailingComposer;
use NZS\Wampiriada\WampiriadaThankYouMailingComposer;
use NZS\Wampiriada\WampiriadaAnnouncementMailingComposer;

use Auth;

class MailingController extends Controller {
	protected $mailings = [
		'initial-response' => WampiriadaThankYouMailingComposer::class,
		'after-edition' => WampiriadaSummaryMailingComposer::class,
		'announcement' => WampiriadaAnnouncementMailingComposer::class,
	];

	public function getIndex() {
		$mailings = collect($this->mailings)->transform(function($class_name) {
			return $class_name::spawnSampleInstance();
		});

        return view('admin.mailing.list', [
			'mailings' => $mailings,
		]);
	}

	public function getPreview($name) {
		if(!isset($this->mailings[$name])) {
			return abort(404);
		}

		$class_name = $this->mailings[$name];

		$composer = $class_name::spawnSampleInstance();

		$mailingManager = app(MailingManager::class);
		$mailingManager->setInPreviewMode();

		return view($composer->getView(), $composer->getSampleContext(Auth::user()));
	}

	public function getShow($name) {
		if(!isset($this->mailings[$name])) {
			return abort(404);
		}

		$class_name = $this->mailings[$name];

		$composer = $class_name::spawnSampleInstance();

		return view('admin.mailing.show', [
			'composer' => $composer,
			'mailing_key' => $name,
			'user' => Auth::user(),
		]);
	}
}
