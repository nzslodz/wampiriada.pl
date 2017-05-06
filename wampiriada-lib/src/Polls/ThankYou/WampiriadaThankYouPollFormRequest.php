<?php namespace NZS\Wampiriada\Polls\ThankYou;

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

/*
1. Czy oddasz krew podczas następnej edycji Wampiriady?
2. Jaki rozmiar koszulki chciałbyś/chciałabyś dostać?
3. Czy zarejestrowałeś/aś się już do bazy dawców szpiku?
Jeśli nie:
3a. Czy zamierzasz zapisać się do bazy dawców szpiku w następnej edycji?
3b. Czy jesteś zainteresowany/a uczestnictwem w bezpłatnej prelekcji(prezentacji?) dotyczącej oddawania szpiku?
4. Czy interesuje cię któryś z poniższych tematów(projektów)? [pola do wyboru]
5. Na jakim wydziale studiujesz?
6. Którego roku studentem jesteś/W którym roku się urodziłeś?
7. [Ewentualnie] Podaj nam swój numer telefonu, abyśmy mogli informować cię o zbliżających się wydarzeniach.
*/
