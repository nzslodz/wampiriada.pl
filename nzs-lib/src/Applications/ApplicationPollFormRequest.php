<?php namespace NZS\Wampiriada;

use Auth;
use NZS\Core\Polls\PollFormRequest;
use Illuminate\Http\Request;
use NZS\Core\Polls\MatchesUserWithEmail;

class ApplicationPollFormRequest extends PollFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'next_edition_participation' => 'boolean',
            'preferred_shirt_size' => 'required|exists:shirt_sizes',
            'is_marrow_donor' => 'boolean',
            'next_edition_marrow_donor' => 'boolean',
            'marrow_donor_lecture' => 'boolean',
            'interests' => 'array',
            'faculty' => 'string',
            'birthday' => '',
            'phone' => '',
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

// https://www.dropbox.com/s/czr957yqgclehgh/Screenshot%202017-03-14%2012.51.10.png?dl=0
