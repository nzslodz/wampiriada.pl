<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Donor;
use Session;

// XXX probably make a trait for messages that could be extended in some way
class CheckinRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function sanitizeName($name) {
        return trim(preg_replace('/\s+/u', ' ', $name));
    }

    /**
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'firstTime' => 'boolean',
            'chosenSize' => 'exists:wampiriada_shirtsizes,id|required',
            'bloodType' => 'in:a_plus,a_minus,b_plus,b_minus,ab_plus,ab_minus,zero_plus,zero_minus,unknown',
            'name' => 'string|min:5|required',
            'email' => 'email|required',
            'facebook_id' => 'nullable|numeric',
            'agreementDataProcessing' => 'boolean|required',
            'agreementEmailNZS' => 'boolean|required',
            'agreementDataProcessing' => 'boolean|required',
        ];
    }

    public function messages() {
        return [
            'required' => 'Pole jest wymagane',
            'exists' => 'Wybierz poprawną opcję',
            'min' => 'Wartość zbyt krótka (minimum :min znaków)',
            'string' => 'Wpisz więcej znaków',
            'in' => 'Podaj właściwą grupę krwi',
        ];
    }
}
