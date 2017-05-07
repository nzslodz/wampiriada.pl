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


use Stevenmaguire\Services\Trello\Client as TrelloClient;
use NZS\Core\TrelloRepository;

class HRController extends Controller {

	/* id, created_at, updated_at, STATUS, HAS_BADGE, IS_MEMBER, MEMBER_SINCE, MEMBER_TO */

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getMemberIndex() {
		$members = Member::whereIsMember(true)->get();

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

	public function getCreateMember() {
		return view('acmin.hr.members.create');
	}

	public function getPersonAutocomplete(Request $request) {
		$input = $request->input('query');

		$people = Person::where('first_name', 'LIKE', "$input%")
			->orWhere('last_name', 'LIKE', "$input%")
			->orWhere('email', 'LIKE', "$input%")
			-limit(10)
			->get();

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
		$member->has_badge = $request->has_badge;
		$member->member_since = $request->member_since;
		$member->member_to = $request->member_to;
		$member->is_member = $request->is_member;

		$member->save();

		return redirect('/admin/hr/members/' . $member->id);
	}

	public function postUpdateMember(MemberRequest $request, $id) {
		$member = Member::findOrFail($id);

		$member->status = $request->status;
		$member->has_badge = $request->has_badge;
		$member->member_since = $request->member_since;
		$member->member_to = $request->member_to;
		$member->is_member = $request->is_member;

		$member->save();

		return redirect('/admin/hr/members/' . $member->id);
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
	}
}
