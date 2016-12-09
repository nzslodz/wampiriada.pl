<?php namespace App\Http\Controllers;

use NZS\Wampiriada\School;
use NZS\Wampiriada\OverallSchools;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\OverallResult;

use DB;
use Input;

use DateTime;
use Illuminate\Http\Request;

class WampiriadaMobileAppController extends Controller {

    protected function getSchoolOverall($school, $year, $edition_type) {
        $school = School::where('short_name', $school)->first();
        if(!$school) {
            return null;
        }

        $current_edition = OverallSchools::where('year', $year)
            ->where('edition_type', $edition_type)
            ->where('school_id', $school->id)->first();

        $last_edition = OverallSchools::where('year', $year - 1)
            ->where('edition_type', $edition_type)
            ->where('school_id', $school->id)->first();

        return array(
            'name' => $school->name,

            'current' => array(
                'overall' => $current_edition->overall
            ),

            'previous' => array(
                'overall' => $last_edition->overall
            ),
        );
    }

    protected function getUpcomingActions($edition_number) {
        $edition = Edition::where('number', $edition_number)->first();

        if(!$edition) {
            return array();
        }

        $actions = ActionDay::with(array('place'))
            ->where('edition_id', $edition->id)
            ->where('hidden', '=', false)
            ->where(DB::raw('DATE(created_at)'), '>', DB::raw('CURRENT_DATE()'))
            ->orWhere(function($query) {
                $query->where(DB::raw('DATE(created_at)'), '=', DB::raw('CURRENT_DATE()'))
                    ->where('end', '>',  DB::raw('ADDTIME(CURRENT_TIME(), "01:00")'));
            })->orderBy('created_at')->get();


        $action_json = array();
        foreach($actions as $action) {
            $start = DateTime::createFromFormat('H:i:s', $action->start);
            $end = DateTime::createFromFormat('H:i:s', $action->end);
            $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $action->created_at);

            $action_json[] = array(
                'place_name' => $action->place->name,
                'place_address' => $action->place->address,
                'start' => $start->format('H:i'),
                'end' => $end->format('H:i'),
                'day' => $created_at->format('d-m-Y'),
            );
        }

        return $action_json;
    }

    public function getOverall(Request $request) {
        $overall = OverallResult::where('year', 2016)->where('edition_type', 2)->first();

        $school = null;
        if($school_name = $request->input('school')) {
            $school = $this->getSchoolOverall($school_name, 2016, 2);
        }

        return response()->json(array(
            'total' => array(
                'overall' => $overall->overall,
            ),

            'school' => $school,

            'notifications' => array(
                /*array(
                    'id' => 5,
                    'name' => 'Patryk Górny',
                    'hospital' => 'III Szpital Miejski im. dr. Karola Jonschera w Łodzi, ul. Milionowa 14',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ),
                array(
                    'id' => 4,
                    'name' => 'Mateusz Kaźmierczak',
                    'hospital' => 'Uniwersytecki Szpital Kliniczny nr 4 im. M. Konopnickiej UM w Łodzi, oddział pediatrii, onkologii i hematologii ul. Sporna 38/50',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ),
                array(
                    'id' => 3,
                    'name' => 'Kazimierz Dąbkowski',
                    'hospital' => 'Klinika Hematologii Unii Lubelskiej w Szczecinie',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ),
                array(
                    'id' => 2,
                    'name' => 'Jacek Ossowski',
                    'hospital' => 'Szpital WAM w Łodzi, Plac Hallera',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ),*/
            ),

            'upcoming_actions' => $this->getUpcomingActions(29),
            'labels' => array(
                'last_year' => 'Wampiriada Jesień 2015',
                'this_year' => 'Wampiriada Jesień 2016',
                'edition' => '29. edycja Wampiriady - Jesień 2016',
                'send_text' => 'http://wampiriada.pl/#r%1$s Wampiriada Jesień 2016 - oddało już %1$s osób!',
            )

        ));
    }
}
