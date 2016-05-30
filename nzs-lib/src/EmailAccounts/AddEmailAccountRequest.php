<?php namespace NZS\Core\EmailAccounts;

use App\Http\Requests\Request;
use Auth;

class AddEmailAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::check();
    }

    public function sanitizePassword($password) {
        return trim($password);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'password' => 'between:8,32|required',
            'email' => 'email|required',
            'alias_email' => 'email|required',
        ];
    }

    public function messages() {
        return [
            'email' => 'Pole nie jest prawidłowym adresem e-mail',
            'required' => 'To pole jest wymagane',
            'between' => 'Hasło powinno zawierać minimum :min znaków oraz maksimum :max znaków',
        ];
    }
}
