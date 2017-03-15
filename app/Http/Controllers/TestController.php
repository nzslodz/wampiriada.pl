<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Container\Container;
use Auth;
use NZS\Core\Activity;

class TestController extends Controller {
	public function getTest() {
		view('magic');

	}
}
