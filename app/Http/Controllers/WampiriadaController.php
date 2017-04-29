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

use NZS\Wampiriada\Redirects\AwareRedirectRepository;

use NZS\Core\Polls\Poll;
use NZS\Core\Polls\UsesPolls;
use NZS\Wampiriada\Polls\ThankYou\WampiriadaThankYouPollFormRequest;


class WampiriadaController extends Controller {
    use UsesPolls;

    public function showIndex() {
        $edition = Option::get('wampiriada.edition', 28);

        $repository = new EditionRepository($edition);

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
            $last_year_edition = new EditionRepository($repository->getEditionNumber() - 2);
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

    public function getRedirectByName(Request $request, $name) {
        $repository = new DatabaseRedirectRepository;

        $redirect_url = $repository->resolveRedirect($name);

        if(!$redirect_url) {
            abort(404);
        }

        return redirect($redirect_url);
    }

    public function getRedirect(Request $request, $edition_number, $name) {
        $edition_repository = new EditionRepository( $edition_number);
        $repository = $edition_repository->getRedirectRepository();

        $redirect_url = $repository->resolveRedirect($name);

        if(!$redirect_url) {
            abort(404);
        }

        $aware_repository = AwareRedirectRepository::fromRequest($request, $repository);
        if($aware_repository) {
            $aware_repository->saveEmailCampaignInfo($name);
        }

        return redirect($redirect_url);
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
                'image' => 'img/partnerzy/02.jpg',
            ],
            'uml-zdrowie' => [
                'title' => 'Wydział Zdrowia Urzędu Miasta Łodzi',
                'link' => 'http://uml.lodz.pl',
                'image' => 'img/partnerzy/03.jpg',
            ],
            'wl-lodzkie' => [
                'title' => 'Promuje Łódzkie',
                'link' => 'http://lodzkie.pl',
                'image' => 'img/partnerzy/04.jpg',
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
                'image' => 'img/partnerzy/07.jpg',
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
                'image' => 'img/partnerzy/26.jpg',
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
                'image' => 'img/partnerzy/mlodziwlodzi.jpg',
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

        ];

        $structure = [
            [ 'lodz-kreuje',  'wl-lodzkie', 'wl-main', 'pzu'],
            [ 'ul', 'pl', 'um', 'wsiu' ],
            [ 'fiero', 'pastago', 'zapiekarnia', 'rytm'],
            [ 'teatr-wielki', 'teatr-nowy', 'teatr-muzyczny', 'goudaworks' ],
            [ 'mlodziwlodzi', 'makimo', 'eska', 'plaster'],
            [ 'infostudent', 'zak', 'wydarzysie', 'studentlodz'],
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
