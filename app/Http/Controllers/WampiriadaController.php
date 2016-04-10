<?php namespace App\Http\Controllers;

use NZS\Wampiriada\EditionRepository;
use NZS\Core\Exceptions\ObjectDoesNotExist;
use App\Libraries\PartnerRow;

class WampiriadaController extends Controller {
    public function showIndex() {
        $edition = 27;

        $repository = new EditionRepository($edition);
        
        $event_redirect = $repository->getRedirect('facebook-event');

        $display_results = true;
        $display_actions = true;

        try {
            $results = $repository->getResults();
        } catch(ObjectDoesNotExist $e) {
            $display_results = false;
            $results = [];
        }

        try {
            $last_year_edition = new EditionRepository($repository->getEdition() - 2);
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

        $oddalo = function($num) {
            $mod_100 = $num % 100;
            $mod_10 = $num % 10;
            
            if($mod_100 > 10 && $mod_100 < 20) {
                return 'osób oddało';
            }

            if($mod_10 > 1 && $mod_10 < 5) {
                return 'osoby oddały';
            }

            return 'osób oddało';
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
            'overall_difference' => $overall_difference,
            'oddalo' => $oddalo,
            'get_class' => $get_class,
            'actions' => $actions,
            'results' => $results,
            'partners' => $this->getPartners(),
        ]);
    }

    // XXX TODO
    public function getRedirect($name, $edition_id=null) {
        return "id: $edition_id, name: $name";
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
                'image' => 'img/partnerzy/13.jpg',
            ],
            'szuster' => [
                'title' => 'Szkoła Języków Obcych Szuster',
                'link' => 'http://www.studium.com.pl',
                'image' => 'img/partnerzy/18.jpg',
            ],
            'fiero' => [
                'title' => 'Pizzeria Fiero!',
                'link' => 'http://fieropizza.pl',
                'image' => 'img/partnerzy/14.jpg',
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
                'image' => 'img/partnerzy/23.jpg',
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
                'image' => 'img/partnerzy/wielki.jpg',
            ],

        ];

        $structure = [
            [ 'uml-main', 'wl-main', 'uml-zdrowie', 'wl-lodzkie', ],
            [ 'ul', 'pl', 'um', 'asp', 'wsiu' ],
            [ 'pzu', 'fiero', 'teatr-wielki', 'teatr-nowy' ],
            [ 'makimo', 'eska', 'plaster', 'dlastudenta'],
            [ 'infostudent', 'zak', 'studentnews', 'studentlodz'],
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
}

