<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewsletterRemoveRequest extends Request
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
            'email' => 'email|required',
            'g-recaptcha-response' => 'recaptcha|required'
        ];
    }

    public function messages() {
        return [
            'required' => 'Pole jest wymagane',
            'email' => 'To nie jest poprawny adres e-mail.',
            'recaptcha' => 'Spróbuj ponownie za jakiś czas.',
        ];
    }
}
