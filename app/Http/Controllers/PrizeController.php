<?php namespace App\Http\Controllers;

use NZS\Core\CollectionAggregator;
use NZS\Core\Storyboards\DjangoAdminStyleStoryboard;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;
use NZS\Wampiriada\FacebookConncection;
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

class PrizeController extends Controller {
	public function getStoryboard() {
		return (new DjangoAdminStyleStoryboard($this))
			->withRoutes('admin-prize-list', 'admin-prize-edit', 'admin-prize-create')
			->withTexts('Zapisz', 'Zapisz i kontynuuj edycję', 'Zapisz i dodaj następny');
	}

	public function getIndex() {
        $edition_number = (int) Option::get('wampiriada.edition', 26);

        return view('admin.prize.list', [
			'prizes' => PrizeType::orderBy('name')->get(),
		]);
	}

	public function getEdit($id=null) {
		$type = PrizeType::findOrNew($id);

		return view('admin.prize.edit', [
			'prize' => $type,
		]);
	}

	public function postEdit(PrizeTypeRequest $request, $id=null) {
		$type = PrizeType::findOrNew($id);

		$type->active = $request->filled('active');
		$type->description = $request->description;
		$type->name = $request->name;

		$type->save();

		return $this->getStoryboard()
			->response($request, $type)
			->with('status', 'success')
			->with('message', 'Typ nagrody poprawnie zapisany');

	}

	public function postToggle(Request $request, PrizeType $type) {
		$type->active = $request->input('active') == 'true';

		$type->save();

		return response()->json([
			'type' => $type->toArray(),
		]);
	}
}
