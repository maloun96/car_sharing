<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Parking.
 */
class Parking extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'status',
		'fast_charging',
		'capacity',
		'price',
		'latitude',
		'longitude',
	];

	protected $table = 'parking';
}
