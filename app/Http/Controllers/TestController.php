<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Container\Container;
use Auth;
use NZS\Core\Activity;
use ReflectionException;


class TestController extends Controller {
	public function getTest() {
		$container = new Container;

		$container->instance('lol', function($a) {
			return $a.'b';
		});

		$f = $container->make('lol');

		try {
			$g = $container->make('cat');
		} catch(ReflectionException $e) {
			$g = function($f) {
				return 'fu';
			};
		}

		dd($f(1), $g(2));
	}
}
