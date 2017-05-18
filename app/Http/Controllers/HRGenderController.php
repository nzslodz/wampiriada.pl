<?php namespace App\Http\Controllers;


use NZS\Core\EmailAccounts\EmailRepository;
use NZS\Core\EmailAccounts\AddEmailAccountRequest;
use NZS\Core\Storyboards\Storyboard;

use Illuminate\Http\Request;
use App\Http\Requests\GenderRequest;

use NZS\Core\Person;

use Mail;

class HRGenderController extends Controller {

	protected function getProbabilityFromRequest(Request $request) {
		$probability = $request->input('probability');

		if(is_numeric($probability)) {
			$probability = floatval($probability);
		} else {
			$probability = 0.5;
		}

		return $probability;
	}

	public function getIndex(Request $request) {
		$probability = $this->getProbabilityFromRequest($request);

		$people = Person::where('gender_probability', '<', $probability)
			->orderBy('id', 'DESC')->get();

		return view('admin.hr.gender.index', [
			'people' => $people,
			'probability' => $probability,
		]);
	}

	public function getGender(Request $request, $id) {
		$probability = $this->getProbabilityFromRequest($request);

		$person = Person::findOrFail($id);

		return view('admin.hr.gender.edit', [
			'person' => $person,
			'probability' => $probability,
		]);
	}

	public function postGender(GenderRequest $request, $id) {
		$person = Person::findOrFail($id);

		if($request->gender != 'skip') {
			$person->updateGender($request->gender);
			$person->save();

			flash('Zmieniono płeć osoby')->success();
		} else {
			flash('Pominięto płeć osoby')->warning();
		}

		return $this->getStoryboard()->response($request, $person);
	}

	public function getStoryboard() {
		$storyboard = new Storyboard($this);

		$storyboard->addTransitionOn('_next', 'next', function($request, $object) {
			$probability = $this->getProbabilityFromRequest($request);

			$person = Person::where('id', '<', $object->id)
				->where('gender_probability', '<', $probability)
				->orderBy('id', 'DESC')
				->first();

			$parameters = [];
			if($probability != 0.5) {
				$parameters['probability'] = $probability;
			}

			if(!$person) {
				flash('Nie ma więcej osób na tej liście.');

				return redirect()->route('admin-hr-gender-index', $parameters);
			}

			$parameters['id'] = $person->id;

			return redirect()->route('admin-hr-gender-edit', $parameters);
		})->withText('przejdź do kolejnej osoby');

		$storyboard->addTransitionOn('_next', 'go-back', function($request, $object) {
			$probability = $this->getProbabilityFromRequest($request);

			$parameters = [];
			if($probability != 0.5) {
				$parameters['probability'] = $probability;
			}

			return redirect()->route('admin-hr-gender-index', $parameters);
		})->withText('wróć do listy');

		$storyboard->useSession();

		return $storyboard;
	}
}
