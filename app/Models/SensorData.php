<?php
// ================================================================
// Nama Sistem  : Aqualyze - Smart Water Monitoring System
// Author       : Refan Rustoni Putra(10824005), Andini Putri Yani(10824011)
// Versi        : 1.3.0
// Tahun        : 2026
// Ownership    : Capstone Project - Universitas
// Deskripsi    : Sistem monitoring kualitas air berbasis IoT
//                dengan API Laravel sebagai backend.
// ================================================================

// ======================= Library ================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $fillable = [
        'device_id',
        'suhu',
        'ph',
        'kekeruhan',
        'status_suhu',
        'status_ph',
        'status_kekeruhan',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}