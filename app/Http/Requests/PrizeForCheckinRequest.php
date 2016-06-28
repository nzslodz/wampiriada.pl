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
            'type.*.id' => 'required|exists:prize_types',
            'type.0.id' => 'required',
        ];
    }

    public function messages() {
        return [
            'required' => 'Pole jest wymagane',
            'exists' => 'Wybierz poprawny typ nagrody',
        ];
    }
}
