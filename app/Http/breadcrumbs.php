<?php

use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\PrizeType;
use NZS\Wampiriada\Editions\Edition;

Breadcrumbs::register('admin-home', function($breadcrumbs) {
    $breadcrumbs->push('Administracja', route('admin-home'));
});

Breadcrumbs::register('admin-wampiriada-list', function($breadcrumbs) {
    $breadcrumbs->parent('admin-home');
    $breadcrumbs->push('Wampiriada', route('admin-wampiriada-list'));
});

Breadcrumbs::register('admin-wampiriada-new', function($breadcrumbs) {
    $breadcrumbs->parent('admin-wampiriada-list');
    $breadcrumbs->push('Dodaj nową edycję', route('admin-wampiriada-new'));
});

Breadcrumbs::register('admin-wampiriada-show', function($breadcrumbs, $number) {
    $breadcrumbs->parent('admin-wampiriada-list');
    $breadcrumbs->push($number . '. edycja', route('admin-wampiriada-show', $number));
});

Breadcrumbs::register('admin-wampiriada-edit', function($breadcrumbs, $id) {
    $action_day = ActionDay::findOrFail($id);
    $edition = Edition::findOrFail($action_day->edition_id);

    $breadcrumbs->parent('admin-wampiriada-show', $edition->number);
    $breadcrumbs->push($action_day->created_at->format('d.m'), route('admin-wampiriada-edit', $id));
});

Breadcrumbs::register('admin-wampiriada-settings', function($breadcrumbs, $number) {
    $breadcrumbs->parent('admin-wampiriada-show', $number);
    $breadcrumbs->push('Ustawienia', route('admin-wampiriada-settings', $number));
});

Breadcrumbs::register('admin-prize-list', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Nagrody', route('admin-prize-list'));
});

Breadcrumbs::register('admin-prize-edit', function($breadcrumbs, $id=null) {
    $type = PrizeType::find($id);

    if($type) {
        $name = $type->name;
    } else {
        $name = 'Nowa';
    }

    $breadcrumbs->parent('admin-prize-list');
    $breadcrumbs->push($name, route('admin-prize-edit', $id));
});

Breadcrumbs::register('admin-wampiriada-prize-summary', function($breadcrumbs, $number) {
    $breadcrumbs->parent('admin-wampiriada-show', $number);
    $breadcrumbs->push('Nagrody', route('admin-wampiriada-prize-summary', $number));
});

Breadcrumbs::register('admin-mailing-list', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Mailingi', route('admin-mailing-list'));
});

Breadcrumbs::register('admin-mailing-show', function($breadcrumbs) {
    $breadcrumbs->parent('admin-mailing-list');
    //$breadcrumbs->push($name, route('admin-mailing-show', $name));
});

Breadcrumbs::register('admin-trello-releases', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Raporty', route('admin-trello-releases'));

});

Breadcrumbs::register('admin-trello-single-release', function($breadcrumbs, $key, $list) {
    $breadcrumbs->parent('admin-trello-releases');
    $breadcrumbs->push('Raport', route('admin-trello-single-release', ['key' => $key, 'list' =>$list]));

});
Breadcrumbs::register('admin-trello-releases-create', function($breadcrumbs, $key) {
    $breadcrumbs->parent('admin-trello-releases');
    $breadcrumbs->push('Nowy raport', route('admin-trello-releases-create', $key));

});
