<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function __get($key) {
    	$value = parent::__get($key);

    	$method_name = camel_case("sanitize_$key");

    	if(method_exists($this, camel_case("sanitize_$key")) {
    		$value = $this->$method_name($value);
    	}

    	return $value;
    }
}
