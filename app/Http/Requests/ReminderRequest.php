<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReminderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'g-recaptcha-response' => 'recaptcha|required',
            'user_id' => 'required_without_all:first_name,last_name,email|numeric',
            'email' => 'required_without:user_id|email',
            'first_name' => 'required_with:email|string',
            'last_name' => 'required_with:email|string',
        ];
    }

    public function messages() {
        return [
            'required' => 'Pole jest wymagane',
            'email' => 'To nie jest poprawny adres e-mail.',
            'recaptcha' => 'Spróbuj ponownie za jakiś czas.',
            'required_with' => 'To pole jest wymagane.',
            'string' => 'To pole jest wymagane.',
            'required_without' => 'To pole jest wymagane.',
        ];
    }
}
