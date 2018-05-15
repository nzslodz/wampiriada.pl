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
use App\Http\Requests\EventRequest;
use NZS\Core\HR\Member;
use NZS\Core\HR\AttendanceAggregator;
use NZS\Core\HR\Event;
use NZS\Core\HR\Attendance;

use NZS\Core\Storyboards\DjangoAdminStyleStoryboard;

use NZS\Core\Person;

use Stevenmaguire\Services\Trello\Client as TrelloClient;
use NZS\Core\TrelloRepository;


/* XXX: should use datetimepicker instead of datepicker for happened_at field */


class HREventController extends Controller {

	public function getStoryboard() {
		return (new DjangoAdminStyleStoryboard($this))
			->withRoutes('admin-hr-events-list', 'admin-hr-events-edit', 'admin-hr-events-create')
			->withTexts('Zapisz', 'Zapisz i kontynuuj edycję', 'Zapisz i dodaj następny');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
		$events = Event::orderBy('happened_at', 'DESC')->get();

        return view('admin.hr.events.list', [
            'events' => $events,
        ]);
	}

	public function getUpdate($id=null) {
		$event = Event::findOrNew($id);

		return view('admin.hr.events.edit', [
			'event' => $event,
		]);
	}

	public function postUpdate(EventRequest $request, $id=null) {
		if($id) {
			$event = Event::findOrFail($id);
		} else {
			$event = new Event;
		}

		$event->is_public = $request->input('is_public', false);
		$event->happened_at = $request->happened_at;
		$event->name = $request->name;
		$event->description = $request->description;

		$event->save();

		return $this->getStoryboard()
			->response($request, $event)
			->with('status', 'success')
			->with('message', 'Zapisano wydarzenie');
	}

	public function getAttendances($id) {
		$event = Event::findOrFail($id);
		$members = Member::whereIsMember(true)->get();
		$aggregator = new AttendanceAggregator($event);

		return view('admin.hr.events.attendances', [
			'members' => $members,
			'event' => $event,
			'attendance_aggregator' => $aggregator,
		]);
	}

	public function postAttendances(Request $request, $id) {
		$event = Event::findOrFail($id);

		$attendees = collect($request->input('attendees'))->only($request->input('active_members'));

		$existing_attendance_ids = Attendance::whereEventId($event->id)->get()->pluck('id')->flip();

		foreach($attendees as $user_id => $attendee_info) {
			$attendance = Attendance::whereEventId($id)->whereUserId($user_id)->first();

			if(!$attendance) {
				$attendance = new Attendance;
				$attendance->user_id = $user_id;
				$attendance->event_id = $event->id;
			}

			if(isset($attendee_info['attended_to']) && !$attendee_info['attended_to']) {
				$attendee_info['attended_to'] = null;
			}

			if(isset($attendee_info['attended_since']) && !$attendee_info['attended_since']) {
				$attendee_info['attended_since'] = null;
			}

			$attendance->fill($attendee_info);

			$attendance->save();

			$existing_attendance_ids->forget($attendance->id);
		}

		foreach($existing_attendance_ids->keys() as $attendance_id) {
			$attendance = Attendance::find($attendance_id);

			if(!$attendance) {
				continue;
			}

			$attendance->delete();
		}

		return redirect()->route('admin-hr-events-show', ['id' => $id]);
	}
}
