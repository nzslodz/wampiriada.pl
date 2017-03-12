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
	public function getIndex() {
		$client = new TrelloClient(array(
		    'key' => config('app.trello.key'),
		    'token'  => config('app.trello.token'),
		));

		$repository = new TrelloRepository($client);

        return view('admin.trello.release.display_cards', [
            'release_cards' => $repository->getCardsFromReleaseBoards(config('app.trello.release_boards')),
        ]);
	}

}
