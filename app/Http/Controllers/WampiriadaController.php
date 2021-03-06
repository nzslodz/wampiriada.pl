<?php namespace App\Http\Controllers;

use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Redirects\DatabaseRedirectRepository;
use NZS\Core\Redirects\CompositeRedirectRepository;
use App\Libraries\PartnerRow;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Redirect;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaign;
use NZS\Wampiriada\Polls\WampiriadaPoll;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResult;
use NZS\Wampiriada\Redirects\WampiriadaRedirectRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ReminderRequest;

use NZS\Core\Polls\Poll;
use NZS\Core\Polls\UsesPolls;
use NZS\Wampiriada\Polls\ThankYou\WampiriadaThankYouPollFormRequest;
use NZS\Wampiriada\Reminders\Reminder;
use NZS\Wampiriada\Donor;
use NZS\Wampiriada\ActionDay;

class WampiriadaController extends Controller {
    use UsesPolls;

    public function showIndex() {
        $repository = EditionRepository::current();

        $event_redirect = $repository->getRedirect('facebook-event');

        $display_results = $repository->getConfiguration()->display_results;
        $display_actions = $repository->getConfiguration()->display_actions;
        $display_faces = $repository->getConfiguration()->display_faces;

        try {
            $results = $repository->getResults();
        } catch(ObjectDoesNotExist $e) {
            $display_results = false;
            $results = [];
        }

        try {
            $last_year_edition = EditionRepository::fromPreviousYear($repository);
            $overall_difference = $repository->getOverallDifference($last_year_edition) * 0.45;
        } catch(ObjectDoesNotExist $e) {
            $overall_difference = false;
        }

        try {
            $actions = $repository->getActions();
        } catch(ObjectDoesNotExist $e) {
            $display_actions = false;
            $actions = [];
        }

        $pluralize = function($num, $strings) {
            $mod_100 = $num % 100;
            $mod_10 = $num % 10;

            if ($num == 0) {
                $val = $strings['zero'];
            } elseif ($num == 1) {
                $val = $strings['one'];
            } elseif ($mod_100 > 10 && $mod_100 < 20) {
                $val = $strings['many'];
            } elseif ($mod_10 > 1 && $mod_10 < 5) {
                $val = $strings['few'];
            } else {
                $val = $strings['many'];
            }
            $val = str_replace(':num', $num, $val);
            return $val;
        };

        $oddalo = function($num) use ($pluralize) {
            return $pluralize($num, [
                'zero' => 'osób oddało',
                'one' => 'osoba oddała',
                'few' => 'osoby oddały',
                'many' => 'osoby oddały',
            ]);
        };
        $odkryte_za = function($num) use ($pluralize) {
            return $pluralize($num, [
                'zero' => 'za :num osób',
                'one' => 'za :num osobę',
                'few' => 'za :num osoby',
                'many' => 'za :num osób',
            ]);
        };

        $school_mapping = array(
            'UŁ' => 'ul',
            'PŁ' => 'pl',
            'UMed' => 'um',
            'WSInfiU' => 'wsinf',
            'AHE' => 'ahe',
            'AMuz' => 'amuz',
            'ASP' => 'asp',
            'PWSFTviT' => 'pwsftvit',
            'Pozostałe' => 'other',
        );

        $get_class = function($short_name) use($school_mapping) {
            return $school_mapping[$short_name];
        };

        return view('wampiriada.index', [
            'event_redirect' => $event_redirect,
            'repository' => $repository,
            'display_actions' => $display_actions,
            'display_results' => $display_results,
            'display_faces' => $display_faces,
            'overall_difference' => $overall_difference,
            'oddalo' => $oddalo,
            'odkryte_za' => $odkryte_za,
            'get_class' => $get_class,
            'actions' => $actions,
            'results' => $results,
            'achievements' => config('app.achievements'),
            'partners' => $this->getPartners(),
            'numberOfCheckins' => Checkin::whereEditionId($repository->getEdition()->id)->count(),
        ]);
    }

    public function getReminder(Request $request, $action_day_id) {
        $action = ActionDay::findOrFail($action_day_id);
        $user = Donor::find($request->session()->get('redirect_user_id'));

        if(!$user) {
            $user = new Donor;
        }

        return view('wampiriada.reminder', [
            'action' => $action,
            'user' => $user,
        ]);
    }

    public function postReminder(ReminderRequest $request, $action_day_id) {
        $action = ActionDay::findOrFail($action_day_id);
        $user = Donor::find($request->input('user_id'));

        if(!$user) {
            $user = Donor::firstOrNew(['email' => $request->email]);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();
        }

        $reminder = Reminder::firstOrCreate([
            'action_day_id' => $action->id,
            'user_id' => $user->id
        ]);

        return redirect('/reminder_ok');
    }

    public function getReminderSuccess(Request $request) {
        return view('wampiriada.reminder_success');
    }

    public function getPartners() {
        $partners = [
            'uml-main' => [
                'title' => 'Urząd Miasta Łodzi',
                'link' => 'http://uml.lodz.pl',
                'image' => 'img/partnerzy/01.jpg',
            ],
            'wl-main' => [
                'title' => 'Urząd Wojewódzki w Łodzi',
                'link' => 'http://lodzkie.pl',
                'image' => 'img/partnerzy/02.png',
            ],
            'uml-zdrowie' => [
                'title' => 'Wydział Zdrowia Urzędu Miasta Łodzi',
                'link' => 'http://uml.lodz.pl',
                'image' => 'img/partnerzy/03.jpg',
            ],
            'wl-lodzkie' => [
                'title' => 'Promuje Łódzkie',
                'link' => 'http://lodzkie.pl',
                'image' => 'img/partnerzy/wl-lodzkie.jpg',
            ],
            'pzu' => [
                'title' => 'Grupa PZU',
                'link' => 'http://pzu.pl',
                'image' => 'img/partnerzy/05.jpg',
            ],
            'fitfabric' => [
                'title' => 'FitFabric',
                'link' => 'http://fitfabric.pl',
                'image' => 'img/partnerzy/06.jpg',
            ],

            'ul' => [
                'title' => 'Uniwersytet Łódzki',
                'link' => 'http://uni.lodz.pl',
                'image' => 'img/partnerzy/ul-neue.jpg',
            ],
            'pl' => [
                'title' => 'Politechnika Łódzka',
                'link' => 'http://p.lodz.pl',
                'image' => 'img/partnerzy/08.jpg',
            ],
            'um' => [
                'title' => 'Uniwersytet Medyczny w Łodzi',
                'link' => 'http://umed.pl',
                'image' => 'img/partnerzy/09.jpg',
            ],
            'wsiu' => [
                'title' => 'Wyższa Szkoła Informatyki i Umiejętności w Łodzi',
                'link' => 'http://wsinf.edu.pl',
                'image' => 'img/partnerzy/wsiu-nowe.jpg',
            ],
            'szuster' => [
                'title' => 'Szkoła Języków Obcych Szuster',
                'link' => 'http://www.studium.com.pl',
                'image' => 'img/partnerzy/18.jpg',
            ],
            'fiero' => [
                'title' => 'Pizzeria Fiero!',
                'link' => 'http://fieropizza.pl',
                'image' => 'img/partnerzy/fiero.png',
            ],
            'makimo' => [
                'title' => 'Makimo Sp. z o.o.',
                'link' => 'http://makimo.pl',
                'image' => 'img/partnerzy/19.jpg',
            ],
            'happylodz' => [
                'title' => 'HappyLodz',
                'link' => 'https://www.facebook.com/HappyLodz',
                'image' => 'img/partnerzy/happylodz.png',
            ],

            'plaster' => [
                'title' => 'Plaster Łódzki',
                'link' => 'http://plasterlodzki.pl',
                'image' => 'img/partnerzy/25.jpg',
            ],

            'dlastudenta' => [
                'title' => 'dlastudenta.pl',
                'link' => 'http://dlastudenta.pl',
                'image' => 'img/partnerzy/27.jpg',
            ],

            'infostudent' => [
                'title' => 'InfoStudent',
                'link' => 'http://www.infosgroup.pl/infostudent/',
                'image' => 'img/partnerzy/infostudent.png',
            ],

            'studentnews' => [
                'title' => 'studentnews.pl',
                'link' => 'http://studentnews.pl',
                'image' => 'img/partnerzy/28.jpg',
            ],

            'zak' => [
                'title' => 'Studenckie Radio Żak',
                'link' => 'http://www.zak.lodz.pl',
                'image' => 'img/partnerzy/zak.png',
            ],

            'studentlodz' => [
                'title' => 'Portal student.lodz.pl',
                'link' => 'http://student.lodz.pl',
                'image' => 'img/partnerzy/29.jpg',
            ],

            'eska' => [
                'title' => 'Radio Eska',
                'link' => 'http://eska.pl',
                'image' => 'img/partnerzy/21.jpg',
            ],

            'asp' => [
                'title' => 'Akademia Sztuk Pięknych im. Władysława Strzemińskiego w Łodzi',
                'link' => 'https://www.asp.lodz.pl',
                'image' => 'img/partnerzy/asp.jpg',
            ],

            'teatr-nowy' => [
                'title' => 'Teatr Nowy im. Kazimierza Dejmka w Łodzi',
                'link' => 'http://www.nowy.pl',
                'image' => 'img/partnerzy/nowy.jpg',
            ],

            'teatr-wielki' => [
                'title' => 'Teatr Wielki w Łodzi',
                'link' => 'http://operalodz.com',
                'image' => 'img/partnerzy/teatr-wielki.jpg',
            ],

            'skybowling' => [
                'title' => 'Skybowling',
                'link' => 'http://skybowling.pl/',
                'image' => 'img/partnerzy/skybowling.jpg',
            ],

            'lodz-kreuje' => [
                'title' => 'Miasto Łódź',
                'link' => 'http://uml.lodz.pl',
                'image' => 'img/partnerzy/lodz-kreuje.jpg',
            ],

            'findout' => [
                'title' => 'Find Out - Escape Room',
                'link' => 'http://findout.com.pl/',
                'image' => 'img/partnerzy/findout.jpg',
            ],

            'teatr-muzyczny' => [
                'title' => 'Teatr Muzyczny w Łodzi',
                'link' => 'http://www.teatr-muzyczny.lodz.pl/',
                'image' => 'img/partnerzy/teatr_muzyczny.jpg',
            ],

            'mlodziwlodzi' => [
                'title' => 'Młodzi w Łodzi',
                'link' => 'https://mlodziwlodzi.pl/',
                'image' => 'img/partnerzy/mlodziwlodzi.png',
            ],

            'goudaworks' => [
                'title' => 'Gouda Works',
                'link' => 'http://www.goudaworks.pl/',
                'image' => 'img/partnerzy/goudaworks.png',
            ],

            'zapiekarnia' => [
                'title' => 'Bistro Zapiekarnia',
                'link' => 'https://www.facebook.com/zapiekarnia/',
                'image' => 'img/partnerzy/logo-bistro.png',
            ],

            'pastago' => [
                'title' => 'Pasta Go',
                'link' => 'https://www.facebook.com/pastagoo/',
                'image' => 'img/partnerzy/pastago.jpg',
            ],

            'rytm' => [
                'title' => 'Fitness Klub Rytm',
                'link' => 'http://www.rytm.pl/',
                'image' => 'img/partnerzy/rytm.jpg',
            ],

            'wydarzysie' => [
                'title' => 'wydarzysie.pl',
                'link' => 'http://wydarzysie.pl/',
                'image' => 'img/partnerzy/wydarzysie.png',
            ],

            'kghm' => [
                'title' => 'Fundacja KGHM',
                'link' => 'http://fundacjakghm.pl/',
                'image' => 'img/partnerzy/kghm.jpg',
            ],

            'bodo' => [
                'title' => 'Kino Bodo',
                'link' => 'https://kinobodo.pl/',
                'image' => 'img/partnerzy/bodo.jpg',
            ],

            'krolkul' => [
                'title' => 'Król Kul',
                'link' => 'http://krolkul.pl/',
                'image' => 'img/partnerzy/krolkul.jpg',
            ],
            'musicschool' => [
                'title' => 'Music School',
                'link' => 'https://szkola-muzyki.pl/',
                'image' => 'img/partnerzy/musicschool.jpg',
            ],
            'mz' => [
                'title' => 'Ministerstwo Zdrowia',
                'link' => 'http://www.mz.gov.pl/',
                'image' => 'img/partnerzy/mzdrowia.jpg',
            ],
            'nck' => [
                'title' => 'Narodowe Centrum Krwi',
                'link' => 'https://www.nck.gov.pl/',
                'image' => 'img/partnerzy/nck.jpg',
            ],
            'saltos' => [
                'title' => 'Park Trampolin Saltos Łódź',
                'link' => 'https://www.saltos.pl/',
                'image' => 'img/partnerzy/saltos.jpg',
            ],
            'szkolafilmowa' => [
                'title' => 'Szkoła Filmowa w Łodzi',
                'link' => 'https://www.filmschool.lodz.pl/',
                'image' => 'img/partnerzy/szkolafilmowa.jpg',
            ],
            'tkalniazagadek' => [
                'title' => 'Tkalnia Zagadek',
                'link' => 'https://tkalniazagadek.pl/',
                'image' => 'img/partnerzy/tkalniazagadek.png',
            ],
            'doktormarchewka' => [
                'title' => 'Doktor Marchewka',
                'link' => 'https://doktormarchewka.com/',
                'image' => 'img/partnerzy/doktormarchewka.png',
            ],
            'wrotkarnia' => [
                'title' => 'Wrotkarnia KołoWrotki',
                'link' => 'http://www.kolowrotki.com.pl/',
                'image' => 'img/partnerzy/wrotkarnia.png',
            ],
            'tulodz' => [
                'title' => 'TuŁódź.com',
                'link' => 'https://tupolska.com/',
                'image' => 'img/partnerzy/tulodz.png',
            ],
            'radiolodz' => [
                'title' => 'Radio Łódź',
                'link' => 'https://www.radiolodz.pl/',
                'image' => 'img/partnerzy/radiolodz.png',
            ],

            'filharmonia' => [
                'title' =>  'Filharmonia Łódzka im. Artura Rubinsteina',
                'link' => 'https://filharmonia.lodz.pl/',
                'image' => 'img/partnerzy/filharmonia.png',
            ],

            'jump-world' => [
                'title' =>  'Park Trampolin JumpWorld Łódź',
                'link' => 'https://www.jumpworld.pl/lodz',
                'image' => 'img/partnerzy/jump-world.png',
            ],

            'laser-game' => [
                'title' =>  'Alfa Laser Game Łódź',
                'link' => 'https://alfalaser.pl/',
                'image' => 'img/partnerzy/laser-game.png',
            ],

            'nordea' => [
                'title' =>  'Grupa Nordea',
                'link' => 'https://nordea.pl',
                'image' => 'img/partnerzy/nordea.png',
            ],

            'paczka' => [
                'title' =>  'Paczka Centrum Artystyczne - Agnieszka Cygan',
                'link' => 'https://paczkacentrumartystyczne.pl/',
                'image' => 'img/partnerzy/paczka.png',
            ],

            'plaster-nowy' => [
                'title' =>  'Plaster Łódzki',
                'link' => 'https://plasterlodzki.pl',
                'image' => 'img/partnerzy/plaster.png',
            ],

            'rollin-barrel' => [
                'title' =>  'The Rollin\' Barrel',
                'link' => 'https://www.facebook.com/TRBarrel/',
                'image' => 'img/partnerzy/rollin-barrel.png',
            ],

            'karta-rabatowa' => [
                'title' =>  'Studencka Karta Rabatowa',
                'link' => 'https://play.google.com/store/apps/details?id=com.altconnect.android.skr&hl=pl',
                'image' => 'img/partnerzy/studencka-karta-rabatowa.png',
            ],

            'teofilow' => [
                'title' =>  'Teofilów S.A.',
                'link' => 'http://www.teofilow.com.pl/',
                'image' => 'img/partnerzy/teofilow.png',
            ],


        ];

        $structure = [
            [ 'lodz-kreuje',  'wl-lodzkie', 'wl-main', ],
            [ 'mz', 'nck', 'nordea', 'paczka' ],
            [ 'ul', 'pl', 'um', 'wsiu' ],
            [ 'teatr-wielki', 'teatr-nowy', 'teatr-muzyczny', 'filharmonia' ],
            [ 'fiero', 'musicschool', 'laser-game', 'tkalniazagadek'],

            [ 'teofilow', 'jump-world', 'rollin-barrel', 'karta-rabatowa', ],
            [ 'mlodziwlodzi', 'makimo', 'eska', 'plaster-nowy'],
            [ 'infostudent', 'zak', 'studentlodz'],
        ];

        $unknown = [
            'title' => 'Does not Exist: Key <strong>%s</strong> in partner store.',
        ];

        $rows = [];

        foreach($structure as $row) {
            $rows[] = new PartnerRow($partners, $row, $unknown);
        }

        return $rows;
    }

    protected function getThankYouMailingPoll($edition_number) {
        $edition = Edition::whereNumber($edition_number)->firstOrFail();

        return WampiriadaPoll::whereHas('poll', function($query) {
            $query->where('key', 'wampiriada_thank_you_mailing_poll');
        })->whereEditionId($edition->id)->firstOrFail();
    }

    protected function getCookieNameForPoll($wampiridada_poll) {
        return sprintf("poll:%s:%d", $wampiridada_poll->poll->key, $wampiridada_poll->edition->number);
    }

    public function showThankYouMailingPoll(Request $request) {
        return $this->showPoll($request, $this->getThankYouMailingPoll(Option::get('wampiriada.edition', 28)));
    }

    public function saveThankYouMailingPoll(WampiriadaThankYouPollFormRequest $request) {
        return $this->savePollAnswer($request, $this->getThankYouMailingPoll(Option::get('wampiriada.edition', 28)));
    }

    public function getKrew() {
        return view('wampiriada.krew');
    }

    public function getSzpik() {
        return view('wampiriada.szpik');
    }
}
