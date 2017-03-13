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
use DB;

use NZS\Core\EmailAccounts\EmailRepository;
use NZS\Core\EmailAccounts\AddEmailAccountRequest;

use App\User;

use Illuminate\Http\Request;

use Mail;

use Stevenmaguire\Services\Trello\Client as TrelloClient;
use NZS\Core\TrelloRepository;

class TrelloController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex(TrelloClient $client) {
		$repositories = collect(config('app.trello.releases', []))->transform(function($config, $key) use($client) {
			return new TrelloRepository($client, $key, $config);
		});

        return view('admin.trello.release.display_releases', [
            'releases' => $repositories,
        ]);
	}

	public function getRelease(TrelloClient $client, $key, $list) {
		$config = config("app.trello.releases.$key");

		if(!$config) {
			abort(404);
		}

		$repository = new TrelloRepository($client, $key, $config);
		$release = $repository->getRelease($list);

		return view('admin.trello.release.display_release', [
			'release' => $release
		]);
	}

	public function showBoardCardsForRelease() {

	}

	public function postRelease() {
		
	}

}
