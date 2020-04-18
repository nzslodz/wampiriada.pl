<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Str;

abstract class Request extends FormRequest
{
    public function __get($key) {
    	$value = parent::__get($key);

    	$method_name = Str::camel("sanitize_$key");

    	if(method_exists($this, Str::camel("sanitize_$key"))) {
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
