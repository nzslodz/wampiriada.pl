<?php namespace App\Http\Controllers;

use NZS\Wampiriada\School;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\ActionDay;

use DB;
use Input;

use DateTime;
use Illuminate\Http\Request;

class WampiriadaMobileAppController extends Controller {

    protected function getSchoolOverall(EditionRepository $repository, $school_name) {
        $last_year_repository = EditionRepository::fromPreviousYear($repository);

        $school = School::where('short_name', $school_name)->first();
        if(!$school) {
            return null;
        }

        $results = $repository->getResultsForSchool($school);
        $last_year_results = $last_year_repository->getResultsForSchool($school);

        return [
            'name' => $school->name,

            'current' => [
                'overall' => $results->sum('overall'),
            ],

            'previous' => [
                'overall' => $last_year_results->sum('overall'),
            ],
        ];
    }

    protected function getUpcomingActions($edition_number) {
        $edition = Edition::where('number', $edition_number)->first();

        if(!$edition) {
            return [];
        }

        $actions = ActionDay::with(['place'])
            ->where('edition_id', $edition->id)
            ->where('hidden', '=', false)
            ->where(DB::raw('DATE(created_at)'), '>', DB::raw('CURRENT_DATE()'))
            ->orWhere(function($query) {
                $query->where(DB::raw('DATE(created_at)'), '=', DB::raw('CURRENT_DATE()'))
                    ->where('end', '>',  DB::raw('ADDTIME(CURRENT_TIME(), "01:00")'));
            })->orderBy('created_at')->get();


        $action_json = [];
        foreach($actions as $action) {
            $start = DateTime::createFromFormat('H:i:s', $action->start);
            $end = DateTime::createFromFormat('H:i:s', $action->end);
            $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $action->created_at);

            $action_json[] = [
                'place_name' => $action->place->name,
                'place_address' => $action->place->address,
                'start' => $start->format('H:i'),
                'end' => $end->format('H:i'),
                'day' => $created_at->format('d-m-Y'),
            ];
        }

        return $action_json;
    }

    public function getOverall(Request $request) {
        $edition_id = (int) Option::get('wampiriada.mobile_edition', 29);

        $repository = EditionRepository::fromNumber($edition_id);

        $school = null;
        if($school_name = $request->input('school')) {
            $school = $this->getSchoolOverall($repository, $school_name);
        }

        return response()->json([
            'total' => [
                'overall' => $repository->getData()->donated,
            ],

            'school' => $school,

            'notifications' => [
                /*[
                    'id' => 5,
                    'name' => 'Patryk Górny',
                    'hospital' => 'III Szpital Miejski im. dr. Karola Jonschera w Łodzi, ul. Milionowa 14',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ],
                [
                    'id' => 4,
                    'name' => 'Mateusz Kaźmierczak',
                    'hospital' => 'Uniwersytecki Szpital Kliniczny nr 4 im. M. Konopnickiej UM w Łodzi, oddział pediatrii, onkologii i hematologii ul. Sporna 38/50',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ],
                [
                    'id' => 3,
                    'name' => 'Kazimierz Dąbkowski',
                    'hospital' => 'Klinika Hematologii Unii Lubelskiej w Szczecinie',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'Jacek Ossowski',
                    'hospital' => 'Szpital WAM w Łodzi, Plac Hallera',
                    'note' => 'Poinformuj w trakcie rejestracji o fakcie oddawania na daną osobę i poproś lekarza, aby wydał zaświadczenie.',
                    'important' => true,
                ],*/
            ],

            'upcoming_actions' => $this->getUpcomingActions($edition_id),
            'labels' => [
                'last_year' => 'Wampiriada Jesień 2015',
                'this_year' => 'Wampiriada Jesień 2016',
                'edition' => '29. edycja Wampiriady - Jesień 2016',
                'send_text' => 'http://wampiriada.pl/#r%1$s Wampiriada Jesień 2016 - oddało już %1$s osób!',
            ],

        ]);
    }
}
