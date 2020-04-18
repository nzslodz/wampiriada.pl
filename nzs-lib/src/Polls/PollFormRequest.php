<?php

namespace NZS\Core\Polls;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use NZS\Core\Contracts\PollFormRequest as PollFormRequestContract;

abstract class PollFormRequest extends FormRequest implements PollFormRequestContract {
    public function sanitize($value, $field) {
        $method_name = Str::camel("sanitize_$field");

        if(method_exists($this, $method_name)) {
            $value = $this->$method_name($value);
        }

        return $value;
    }

    public function getPollFields() {
        return array_keys($this->rules());
    }

    public function getSanitizedData() {
        return collect($this->all())
            ->only($this->getPollFields())
            ->transform([$this, 'sanitize']);
    }

    // let the flow class decide for authorization
    public function authorize() {
        return true;
    }
}
