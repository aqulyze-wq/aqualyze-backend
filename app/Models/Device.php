<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [

        'device_id',

        'nama_device',
        
        'jenis_ikan',

        'lokasi',

        'latitude',

        'longitude',

        'altitude',

        'ip_address',

        'status',

        'last_seen',

    ];

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }
}