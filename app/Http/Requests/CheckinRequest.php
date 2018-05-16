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
        if(!Session::get('checkin_user_id')) {
            return false;
        }

        return true;
    }

    public function sanitizeName($name) {
        return trim(preg_replace('/\s+/u', ' ', $name));
    }

    public function extraValidation($validator) {
        $validator->sometimes('email', 'email|required', function($input) {
            $user = Donor::find(Session::get('checkin_user_id'));

            return empty($user->email);
        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_time' => 'boolean',
            'size' => 'exists:wampiriada_shirtsizes,id|required',
            'blood_type' => 'in:a_plus,a_minus,b_plus,b_minus,ab_plus,ab_minus,zero_plus,zero_minus,unknown',
            'name' => 'string|min:5|required',
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
