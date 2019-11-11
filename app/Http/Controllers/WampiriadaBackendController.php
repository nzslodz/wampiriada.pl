<?php namespace App\Http\Controllers;

use NZS\Wampiriada\Option;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;
use NZS\Wampiriada\PrizeAggregator;
use NZS\Wampiriada\FacebookConncection;
use NZS\Wampiriada\ActionDataAggregator;
use NZS\Wampiriada\Editions\EditionConfiguration;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Editions\EditionData;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\PrizeType;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\ActionDay;
use NZS\Core\Redirects\Redirect;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\Redirects\WampiriadaRedirect;
use NZS\Wampiriada\Editions\EmptyConfiguration;
use NZS\Wampiriada\Reminders\Reminder;
use NZS\Wampiriada\Place;
use DB;
use Carbon\Carbon;

use Throwable;

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
		$edition_object = Edition::whereNumber($number)->first();

        $actions = ActionDay::whereEditionId($edition_object->id)->orderBy('created_at')->get();

        $actions_with_data = $actions->filter(function($action) {
            return (bool) $action->data;
        });

        $actions_without_data = $actions->filter(function($action) {
            return !$action->data;
        })->pluck('short_description', 'id');

        return view('admin.wampiriada.show_edition', array(
            'edition' => $number,
			'edition_object' => $edition_object,
            'actions' => $actions_with_data,
            'choices' => $actions_without_data,
			'reminder_actions' => $actions,
			'iterator' => 0,
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
        $action = ActionDay::findOrFail($id);

        $action_data = $action->data;
        if(!$action_data) {
            $action_data = new ActionData;
        }

        $checkins = Checkin::whereActionDayId($id)->orderBy('created_at')->get();

        return view('admin.wampiriada.edit', array(
            'action' => $action,
            'data' => $action_data,
            'checkins' => $checkins,
			'prize_types' => PrizeType::whereActive(true)->pluck('name', 'id'),
            'checkin_count' => $checkins->count(),
            'first_time_checkin_count' => $action_data->first_time,
            'first_time_checkin_count_percentage' => $action_data->getFirstTimePercentage(),
            'missing_count' => $action_data->overall - $checkins->count(),
        ));
	}

    public function postEdit(Request $request, $id) {
        $action = ActionDay::findOrFail($id);

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
		$repository = new EditionRepository($edition);

        $checkboxes = ShirtSize::get();

		$mapping = collect([
			'redirect_event' => 'facebook-event',
			'redirect_koszulka' => 'koszulka',
			'redirect_plakat' => 'plakat',
		]);

		$mapping->transform(function($redirect_key) use ($edition) {
			$wampiriada_redirect = WampiriadaRedirect::whereHas('redirect', function($query) use($redirect_key) {
				$query->where('key', '=', $redirect_key);
			})->whereEditionId($edition->id)->first();

			if(!$wampiriada_redirect || !$wampiriada_redirect->redirect) {
				return new Redirect;
			}

			return $wampiriada_redirect->redirect;
		});

		$mapping['configuration'] = $repository->getConfiguration();
		$mapping['edition_number'] = $number;
		$mapping['checkboxes'] = $checkboxes;
		$mapping['exists'] = true;
		$mapping['actions'] = ActionDay::whereEditionId($edition->id)->orderBy('created_at')->get();
		$mapping['places'] = Place::get();

        return view('admin.wampiriada.settings', $mapping->all());
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
            'redirect_event' => new Redirect,
            'redirect_koszulka' => new Redirect,
            'redirect_plakat' => new Redirect,
			'configuration' => new EmptyConfiguration,
            'checkboxes' => $checkboxes,
			'actions' => null,
			'exists' => false,
			'places' => Place::get(),
        ]);
    }

    public function postSettings(Request $request, $number) {
        $edition = Edition::whereNumber($number)->first();

		DB::beginTransaction();

		try {
			if(!$edition) {
				$edition = new Edition;
				$edition->number = $number;
				$edition->name = "$number. edycja";
				$edition->save();

				$data = new EditionData;
				$data->id = $edition->id;
				$data->save();
			}

			// Set shirt sizes
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

			// Set configuration flags
			$configuration = $edition->configuration;
			if(!$configuration) {
				$configuration = new EditionConfiguration;
				$configuration->id = $edition->id;
			}

			$configuration->display_faces = $request->filled('display_faces');
			$configuration->display_actions = $request->filled('display_actions');
			$configuration->display_results = $request->filled('display_results');

			$configuration->save();

			// Set redirects
	        foreach($redirects as $key => $field) {
				$new_url = trim($request->input($field));

				$wampiriada_redirect = WampiriadaRedirect::whereHas('redirect', function($query) use($key) {
					$query->where('key', '=', $key);
				})->whereEditionId($edition->id)->first();

				if($wampiriada_redirect) {
					if(!$new_url) {
						// will cascade
						$wampiriada_redirect->redirect->delete();
						continue;
					}

					$redirect = $wampiriada_redirect->redirect;

					$redirect->url = $new_url;
					$redirect->save();

					continue;
				}

				if(!$new_url) {
					continue;
				}

				$redirect = new Redirect;
				$redirect->key = $key;
				$redirect->url = $new_url;
				$redirect->save();

				$wampiriada_redirect = new WampiriadaRedirect;
				$wampiriada_redirect->edition_id = $edition->id;
				$wampiriada_redirect->redirect_id = $redirect->id;
				$wampiriada_redirect->save();
	        }

			// Set actions
			$action_inputs = $request->input('action', []);

			$valid_action_ids = [];
			foreach($action_inputs as $action_input) {
				$action_day = null;
				if(isset($action_input['id'])) {
					$action_day = ActionDay::find($action_input['id']);
				}

				if(!$action_day) {
					$action_day = new ActionDay;
					$action_day->edition_id = $edition->id;
				}

				$action_day->place_id = $action_input['place_id'];
				$action_day->start = $action_input['start'];
				$action_day->end = $action_input['end'];
				$action_day->marrow = isset($action_input['marrow']);
				$action_day->hidden = isset($action_input['hidden']);
				$action_day->created_at = $action_input['day'];

				$action_day->save();

				$valid_action_ids[] = $action_day->id;
			}

			// remove actions that are not in the form
			ActionDay::doesntHave('checkins')
				->whereEditionId($edition->id)
				->whereNotIn('id', $valid_action_ids)
				->delete();

			$protected_actions = ActionDay::has('checkins')
				->whereEditionId($edition->id)
				->whereNotIn('id', $valid_action_ids)
				->get();

			$first_action_day = ActionDay::whereEditionId($edition->id)
				->whereHidden(false)
				->orderBy('created_at', 'ASC')
				->first();

			if($first_action_day) {
				$edition->start_date = $first_action_day->created_at;
			}

			$last_action_day = ActionDay::whereEditionId($edition->id)
				->whereHidden(false)
				->orderBy('created_at', 'DESC')
				->first();

			if($last_action_day) {
				$edition->end_date = $last_action_day->created_at;
			}

			$edition->save();

			DB::commit();
		}  catch (Throwable $e) {
    		DB::rollback();
    		throw $e;
		}

        return redirect('admin/wampiriada/show/' . $number)
			->with('message', 'Zmiany zapisane poprawnie')
			->with('status', 'success')
			->with('$protected_actions', $protected_actions);
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
		}

		$prize->save();

		$prize->items()->sync($request->input('type.*.id'));

		return redirect()->back();
	}

	public function prizeSummary($number) {
		$edition = Edition::whereNumber($number)->firstOrFail();

		$prizes = PrizeForCheckin::whereHas('checkin', function($query) use($edition) {
			$query->where('edition_id', $edition->id);
		})->get();

		// XXX PrizeAggregator
		$aggregator = new PrizeAggregator($prizes);

		return view('admin.wampiriada.prize_summary', [
			'iterator' => 0,
			'edition' => $edition,
			'summary' => $aggregator,
			'prizes' => $prizes->groupBy(function($prize) {
				return $prize->checkin->action_day_id;
			}),
		]);
	}

}
