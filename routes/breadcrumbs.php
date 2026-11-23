<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Str;

Breadcrumbs::for('homepage', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('homepage'));
});

Breadcrumbs::for('extensions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('homepage');
    $trail->push('Extensions', route('extensions.index'));
});

Breadcrumbs::for('extensions.show', function (BreadcrumbTrail $trail, $extension) {
    $trail->parent('extensions.index');
    $trail->push($extension->title, route('extensions.show', $extension));
});

Breadcrumbs::for('documentation.root', function (BreadcrumbTrail $trail) {
    $trail->parent('homepage');
    $trail->push('Documentation', route('documentation.root'));
});

Breadcrumbs::for('documentation.show', function (BreadcrumbTrail $trail, $version, $page) {
    $trail->parent('documentation.root');
    $trail->push($version, route('documentation.redirect', ['page' => $version]));
    $trail->push(Str::studly($page), route('documentation.show', compact('version', 'page')));
});
