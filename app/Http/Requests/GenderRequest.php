<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use NZS\Core\Person;
use NZS\Core\HR\Member;

use Session;

use Illuminate\Validation\Rule;

class GenderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'gender' => 'in:male,female,skip',
        ];
    }

    public function messages() {
        return [
            'in' => 'Niewłaściwa płeć',
        ];
    }
}
