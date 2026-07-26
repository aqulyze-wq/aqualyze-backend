<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'jenis_ikan',
        'lokasi',
        'status',
        'ip_address',
        'latitude',
        'longitude',
        'altitude',
        'last_seen',
    ];
}