<?php namespace App\Http\Controllers;

use NZS\Wampiriada\School;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\ActionDay;

use DB;
use Input;

use DateTime;
use Illuminate\Http\Request;

class ApplicationController extends Controller {

    protected function postNewApplication(Request $request) {
        if($request->input('token') !== config('services.zapier.token')) {
            abort(401);
        }

        return response()->json($request->input());
    }
}
