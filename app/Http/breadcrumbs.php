<?php

use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\Edition;

Breadcrumbs::register('admin', function($breadcrumbs) {
    $breadcrumbs->push('Administracja', route('admin-home'));
});

Breadcrumbs::register('admin-wampiriada-list', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Wampiriada', route('admin-wampiriada-list'));
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
