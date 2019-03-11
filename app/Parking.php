<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
  protected $fillable = [
    'parking_name',
    'parking_status',
    'parking_type',
    'parking_capacity',
    'parking_price',
    'parking_latitude',
    'parking_longitude'
  ];
}
