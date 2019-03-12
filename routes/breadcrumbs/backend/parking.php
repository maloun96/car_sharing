<?php

Breadcrumbs::for('admin.parking.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Parking', route('admin.parking.index'));
});
Breadcrumbs::for('admin.parking.create', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Parking', route('admin.parking.index'));
});
Breadcrumbs::for('admin.parking.edit', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Parking', route('admin.parking.index'));
});
