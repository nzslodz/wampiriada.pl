<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function __get($key) {
    	$value = parent::__get($key);

    	$method_name = camel_case("sanitize_$key");

    	if(method_exists($this, camel_case("sanitize_$key"))) {
    		$value = $this->$method_name($value);
    	}

    	return $value;
    }

    public function validator($factory) {
    	$validator = $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );

    	$validator = $this->extraValidation($validator);

    	return $validator;
    }

    public function extraValidation($validator) {
    	return $validator;
    }
}
