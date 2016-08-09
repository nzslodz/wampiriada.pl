<?php namespace NZS\Wampiriada;

use Auth;
use NZS\Core\Polls\PollFormRequest;
use Illuminate\Http\Request;

class WampiriadaThankYouPollFormRequest extends PollFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'test' => 'string',
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
