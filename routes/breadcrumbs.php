<?php

Breadcrumbs::for('homepage', function ($trail) {
    $trail->push('Home', route('homepage'));
});

Breadcrumbs::for('extensions.index', function ($trail) {
    $trail->parent('homepage');
    $trail->push('Extensions', route('extensions.index'));
});

Breadcrumbs::for('extensions.show', function ($trail, $extension) {
    $trail->parent('extensions.index');
    $trail->push($extension->title, route('extensions.show', $extension));
});

Breadcrumbs::for('documentation.root', function ($trail) {
    $trail->parent('homepage');
    $trail->push('Documentation', route('documentation.root'));
});

Breadcrumbs::for('documentation.show', function ($trail, $version, $page) {
    $trail->parent('documentation.root');
    $trail->push($version, route('documentation.redirect', ['page' => $version]));
    $trail->push(studly_case($page), route('documentation.show', compact('version', 'page')));
});
