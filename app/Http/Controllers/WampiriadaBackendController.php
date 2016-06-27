<?php namespace App\Http\Controllers;

use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\PrizeForCheckin;
use NZS\Wampiriada\PrizeAggregator;
use NZS\Wampiriada\FacebookConncection;
use NZS\Wampiriada\ActionDataAggregator;
use NZS\Wampiriada\FriendCheckinDecorator;
use NZS\Wampiriada\PrizeForCheckinActivityClass;
use NZS\Wampiriada\PrizeForCheckinClaimedActivityClass;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\PrizeType;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\Redirect;
use DB;
use Carbon\Carbon;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\PrizeForCheckinRequest;

class WampiriadaBackendController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
        $edition_number = (int) Option::get('wampiriada.edition', 26);

        return redirect('admin/wampiriada/show/' . $edition_number);
	}

    public function getList() {
        $editions = Edition::orderBy('number')->get();

        return view('admin.wampiriada.list', [
            'editions' => $editions,
        ]);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($number) {
        $actions = Action::where('number', $number)->orderBy('day')->get();
		$edition_object = Edition::whereNumber($number)->first();

        $actions_with_data = $actions->filter(function($action) {
            return (bool) $action->data;
        });

        $actions_without_data = $actions->filter(function($action) {
            return !$action->data;
        })->lists('short_description', 'id');

        return view('admin.wampiriada.show_edition', array(
            'edition' => $number,
			'edition_object' => $edition_object,
            'actions' => $actions_with_data,
            'choices' => $actions_without_data,
            'summary' => new ActionDataAggregator($actions_with_data),
        ));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit(Request $request, $id) {
        $action = Action::findOrFail($id);

        $action_data = $action->data;
        if(!$action_data) {
            $action_data = new ActionData;
        }

        $checkins = Checkin::whereActionDayId($id)->orderBy('created_at')->get();

        $first_time_checkin_count = $checkins->filter(function($checkin) {
            return $checkin->first_time;
        })->count();

        $first_time_checkin_count_percentage = round(100 * $first_time_checkin_count / $action_data->getOverall());

        return view('admin.wampiriada.edit', array(
            'action' => $action,
            'data' => $action_data,
            'checkins' => $checkins,
			'prize_types' => PrizeType::whereActive(true)->lists('name', 'id'),
            'checkin_count' => $checkins->count(),
            'first_time_checkin_count' => $first_time_checkin_count,
            'first_time_checkin_count_percentage' => $first_time_checkin_count_percentage,
            'missing_count' => $action_data->getOverall() - $checkins->count(),
        ));
	}

    public function postEdit(Request $request, $id) {
        $action = Action::findOrFail($id);

        $action_data = $action->data;
        if(!$action_data) {
            $action_data = new ActionData;
            $action_data->id = $id;
        }

        $action_data->a_plus = $request->input('a_plus', 0);
        $action_data->a_minus = $request->input('a_minus', 0);
        $action_data->b_plus = $request->input('b_plus', 0);
        $action_data->b_minus = $request->input('b_minus', 0);
        $action_data->ab_plus = $request->input('ab_plus', 0);
        $action_data->ab_minus = $request->input('ab_minus', 0);
        $action_data->zero_plus = $request->input('zero_plus', 0);
        $action_data->zero_minus = $request->input('zero_minus', 0);
        $action_data->unknown = $request->input('unknown', 0);

        $action_data->save();

        return redirect('admin/wampiriada/show/' . $action->number);
    }

    public function getSettings(Request $request, $number) {
        $edition = Edition::whereNumber($number)->firstOrFail();

        $checkboxes = ShirtSize::get();

        return view('admin.wampiriada.settings', [
            'edition_number' => $number,
            'redirect_event' => Redirect::firstOrNew(['key' => 'facebook-event', 'edition_id' => $edition->id]),
            'redirect_koszulka' => Redirect::firstOrNew(['key' => 'koszulka', 'edition_id' => $edition->id]),
            'redirect_plakat' => Redirect::firstOrNew(['key' => 'plakat', 'edition_id' => $edition->id]),
            'checkboxes' => $checkboxes,
        ]);
    }

    public function getNew(Request $request) {
        $edition = new Edition;

        $last_edition = Edition::orderBy('number', 'DESC')->first();
        if($last_edition) {
            $number = $last_edition->number + 1;
        } else {
            $number = 1;
        }

        $checkboxes = ShirtSize::get();

        return view('admin.wampiriada.settings', [
            'edition_number' => $number,
            'redirect_event' => Redirect::firstOrNew(['key' => 'facebook-event', 'edition_id' => $edition->id]),
            'redirect_koszulka' => Redirect::firstOrNew(['key' => 'koszulka', 'edition_id' => $edition->id]),
            'redirect_plakat' => Redirect::firstOrNew(['key' => 'plakat', 'edition_id' => $edition->id]),
            'checkboxes' => $checkboxes,
        ]);
    }

    // XXX - handle new editions
    public function postSettings(Request $request, $number) {
        $edition = Edition::whereNumber($number)->firstOrFail();

        $sizes = $request->input('sizes');
        if(!is_array($sizes)) {
            $sizes = [];
        }

        foreach(ShirtSize::get() as $shirt_size) {
            $shirt_size->active = in_array($shirt_size->id, $sizes);
            $shirt_size->save();
        }

        $redirects = [
            'facebook-event' => 'redirect_event',
            'koszulka' => 'redirect_koszulka',
            'plakat' => 'redirect_plakat',
        ];

        foreach($redirects as $key => $field) {
            $redirect = Redirect::firstOrNew(['key' => $key, 'edition_id' => $edition->id]);
            $redirect->url = $request->input($field);

            if($redirect->url) {
                $redirect->save();
            }
        }

        return redirect('admin/wampiriada/show/' . $number)->with('message', 'Zmiany zapisane poprawnie')->with('status', 'success');
    }

	public function postResults(Request $request) {
	    return redirect('admin/wampiriada/edit/' . $request->input('id'));
    }

    public function postPrize(PrizeForCheckinRequest $request, Checkin $checkin) {
		$prize = PrizeForCheckin::firstOrNew([
			'checkin_id' => $checkin->id,
		]);

		if($request->claimed && !$prize->claimed_at) {
			$prize->claimed_at = Carbon::now();

			$activity_class = new PrizeForCheckinClaimedActivityClass;
			$activity_class->saveActivityInstance($prize);
		}

		$prize->save();

		$prize->items()->sync($request->input('type.*.id'));

		return redirect()->back();
	}

    public function getFacebookConnections(Request $request, $number) {
        $edition = Edition::whereNumber($number)->firstOrFail();

        $checkins = Checkin::with('user', 'friend_checkins.checkin.user')
			->whereEditionId($edition->id)
			->get()
			->transform(function($checkin) {
				return new FriendCheckinDecorator($checkin);
			});

        return view('admin.wampiriada.facebook_connections', [
            'connections' => $checkins->sortByDesc(function($decorator) {
				return $decorator->getScore();
			}),
        ]);
    }

	public function prizeSummary($number) {
		$edition = Edition::whereNumber($number)->firstOrFail();

		$prizes = PrizeForCheckin::whereHas('checkin', function($query) use($edition) {
			$query->where('edition_id', $edition->id);
		})->get();

		// XXX PrizeAggregator
		$aggregator = new PrizeAggregator($prizes);

		return view('admin.wampiriada.prize_summary', [
			'edition' => $edition,
			'summary' => $aggregator,
			'prizes' => $prizes,
		]);
	}

}
