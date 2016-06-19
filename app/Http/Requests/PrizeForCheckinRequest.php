<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Edition;

class PrizeForCheckinRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::check() && Auth::user()->is_staff;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'claimed' => 'boolean',
            'description' => 'string|min:4|required',
        ];
    }

    public function messages() {
        return [
            'required' => 'Pole jest wymagane',
            'exists' => 'Wybierz poprawną opcję',
            'min' => 'Wartość zbyt krótka (minimum :min znaków)',
        ];
    }
}
