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

use Illuminate\Http\Request;

use Mail;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\CreateMemberRequest;
use NZS\Core\HR\Member;

use NZS\Core\Storyboards\DjangoAdminStyleStoryboard;

use NZS\Core\Person;

use Stevenmaguire\Services\Trello\Client as TrelloClient;
use NZS\Core\TrelloRepository;

class HRController extends Controller {

	/* id, created_at, updated_at, STATUS, HAS_BADGE, IS_MEMBER, MEMBER_SINCE, MEMBER_TO */

	public function getStoryboard() {
		return (new DjangoAdminStyleStoryboard($this))
			->withRoutes('admin-hr-members-list', 'admin-hr-members-edit', 'admin-hr-members-create')
			->withTexts('Zapisz', 'Zapisz i kontynuuj edycję', 'Zapisz i dodaj następny');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getMemberIndex() {
		$members = Member::with('user')->whereIsMember(true)->get();

        return view('admin.hr.members.list', [
            'members' => $members,
        ]);
	}

	public function getMember($id) {
		$member = Member::findOrFail($id);

		return view('admin.hr.members.show', [
			'member' => $member,
		]);
	}

	public function getUpdateMember($id) {
		$member = Member::findOrFail($id);

		return view('admin.hr.members.edit', [
			'member' => $member,
		]);
	}

	public function getCreateMember() {
		return view('admin.hr.members.create');
	}

	public function getPersonAutocomplete(Request $request) {
		$input = $request->input('q');

		$people = Person::doesntHave('member')
			->where(function($query) use($input) {
				$query->where('first_name', 'LIKE', "$input%")
				->orWhere('last_name', 'LIKE', "$input%")
				->orWhere('email', 'LIKE', "$input%");
			})
			->limit(10)
			->offset($request->input('page', 0) * 10)
			->get()
			->transform(function($person) {
				$person->text = sprintf("%s <%s>", $person->getFullName(), $person->email);

				return $person;
			});

		return response()->json($people);
	}

	public function postCreateMember(CreateMemberRequest $request) {
		$person = Person::find($request->id);

		if(!$person) {
			$person = new Person;
			$person->first_name = $request->input('person.first_name');
			$person->last_name = $request->input('person.last_name');
			$person->email = $request->input('person.email');
			$person->save();
		}

		$member = new Member;
		$member->id = $person->id;
		$member->status = $request->status;
		$member->has_badge = $request->input('has_badge', false);
		$member->member_since = $request->member_since === '' ? null: $request->member_since;
		$member->member_to = $request->member_to === '' ? null: $request->member_to;
		$member->is_member = $request->input('is_member', false);

		$member->save();

		$member = Member::findOrFail($person->id);

		return $this->getStoryboard()
			->response($request, $member)
			->with('status', 'success')
			->with('message', 'Utworzono nową osobę');
	}

	public function postUpdateMember(MemberRequest $request, $id) {
		$member = Member::findOrFail($id);

		$member->status = $request->status;
		$member->has_badge = $request->input('has_badge', false);
		$member->member_since = $request->member_since === '' ? null: $request->member_since;
		$member->member_to = $request->member_to === '' ? null: $request->member_to;
		$member->is_member = $request->input('is_member', false);

		$member->save();

		return $this->getStoryboard()
			->response($request, $member)
			->with('status', 'success')
			->with('message', 'Zapisano dane osoby');
	}

	public function getDeleteMember($id) {
		$member = Member::findOrFail($id);

		return view('admin.hr.members.delete', [
			'member' => $member,
		]);
	}

	public function postDeleteMember($id) {
		$member = Member::findOrFail($id);

		$member->delete();

		return redirect()->route('admin-hr-members-list')
			->with('status', 'success')
			->with('message', 'Pomyślnie usunięto osobę');
	}
}
