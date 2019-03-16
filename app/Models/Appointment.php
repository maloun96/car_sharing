<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Appointment.
 */
class Appointment extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_number',
        'data',
        'time',
        'parking_id',
        'parking_id',
        'user_id',
    ];

    protected $table = 'appointments';

    /**
     * Get the phone record associated with the user.
     */
    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    /**
     * Get the phone record associated with the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
