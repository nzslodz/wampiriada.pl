<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Donor;
use Session;

/*
userInput: {
    bloodType: null,
    chosenSize: null,
    firstTime: false,
    name: null,
    email: null,
    facebook_id: null,

    agreementDataProcessing: false,
    agreementEmailWampiriada: false,
    agreementEmailNZS: false,
}
 */

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

    public function getNameAsPair() {
        $list = explode(' ', $this->name);

        if(count($list) != 2) {
            return [null, null];
        }

        return $list;
    }

    /**
     * Get an unsaved Donor instance from request. Update name, fb_id and email.
     * @return [Donor|null] Specified donor or null if user didn't agree to data processing.
     */
    public function getDonor() {
        if(!$this->agreementDataProcessing) {
            return null;
        }

        $donor = $this->getDonorByFacebookId()
            ?: $this->getDonorByEmail()
            ?: new Donor;

        return $this->decorateDonorInstance($donor);
    }

    protected function getDonorByFacebookId() {
        if(!$this->facebook_id) {
            return null;
        }

        return Donor::whereFacebookUserId($this->facebook_id)->first();
    }

    protected function getDonorByEmail() {
        if(!$this->email) {
            return null;
        }

        return Donor::whereEmail($this->email)->first();
    }

    protected function decorateDonorInstance(Donor $user) {
        $user->facebook_user_id = $this->facebook_id;
        $user->email = $this->email;

        $user->consent_email_nzs = $this->agreementEmailNZS;
        $user->consent_email_wampiriada = $this->agreementEmailWampiriada;

        list($user->first_name, $user->last_name) = $this->getNameAsPair();

        return $user;
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
            'name' => 'nullable|string|min:5',
            'email' => 'nullable|email',
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
