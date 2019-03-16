<?php

Breadcrumbs::for('admin.appointment.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Appointment', route('admin.appointment.index'));
});
Breadcrumbs::for('admin.appointment.create', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Appointment', route('admin.appointment.index'));
});
Breadcrumbs::for('admin.appointment.edit', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Appointment', route('admin.appointment.index'));
});
