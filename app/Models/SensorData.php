<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $table = 'sensor_data';

    protected $fillable = [
        'suhu',
        'ph',
        'kekeruhan',
        'status_suhu',
        'status_ph',
        'status_kekeruhan'
    ];
}