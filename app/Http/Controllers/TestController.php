<?php namespace App\Http\Controllers;


use App\User;

use Illuminate\Http\Request;

use Illuminate\Container\Container;
use Auth;
use NZS\Core\Activity;

class TestController extends Controller {
	public function getTest() {
		$container = new Container;

		//$container->instance(User::class, null);

		dd($container->make(User::class));


	}
}