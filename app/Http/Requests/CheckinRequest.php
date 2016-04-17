<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Edition;

class CheckinRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        if(!Auth::check()) {
            return false;
        }

        $edition_number = Option::get('wampiriada.edition', 28);
        $edition = Edition::whereNumber($edition_number)->first();
        if(!$edition) {
            throw new LogicException("Edition does not exist for number $edition_number"); 
        }

        $user = Auth::user();

        $checkin = Checkin::whereUserId($user->id)->whereEditionId($edition->id)->first();
        if($checkin) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_time' => 'boolean',
            'size' => 'exists:shirt_sizes,id|required',
            'blood_type' => 'exists:blood_types,id|required',
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
