<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use NZS\Core\Person;
use NZS\Core\HR\Member;

use Session;

use Illuminate\Validation\Rule;

class CreateMemberRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function extraValidation($validator) {
        $check_function = function($input) {
            return !Person::whereId($input->id)->exists();
        };

        $validator->sometimes('person.email', 'email|required', $check_function);
        $validator->sometimes(['person.first_name', 'person.last_name'], 'string|required|max:255', $check_function);
        $validator->sometimes('person.gender', 'in:male,female|required', $check_function);

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'id' => 'sometimes|exists:people',
            'status' => [Rule::in(Member::getStatuses())],
            'has_badge' => 'boolean',
            'is_member' => 'boolean',
            'member_since' => 'nullable|datetime',
            'member_to' => 'nullable|datetime',
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
