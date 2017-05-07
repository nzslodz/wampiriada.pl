<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use NZS\Core\Person;
use NZS\Core\HR\Member;

use Session;

use Illuminate\Validation\Rule;

class MemberRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        /* id, created_at, updated_at, STATUS, HAS_BADGE, IS_MEMBER, MEMBER_SINCE, MEMBER_TO */

        return [
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
