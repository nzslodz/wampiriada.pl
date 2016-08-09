<?php

namespace NZS\Core\Polls;

use Illuminate\Foundation\Http\FormRequest;
use NZS\Core\Contracts\PollFormRequest as PollFormRequestContract;

abstract class PollFormRequest extends FormRequest implements PollFormRequestContract {
    public function sanitize($value, $field) {
        $method_name = camel_case("sanitize_$field");

        if(method_exists($this, $method_name)) {
            $value = $this->$method_name($value);
        }

        return $value;
    }

    public function getSanitizedData() {
        return collect($this->all())
            ->only(array_keys($this->rules()))
            ->transform([$this, 'sanitize']);
    }

    // let the flow class decide whare
    public function authorize() {
        return true;
    }
}
