<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleEngine extends Model
{
    protected $table = 'rule_engine';

    protected $fillable = [
        'temperature_normal_min',
        'temperature_normal_max',
        'temperature_warning_min',
        'temperature_warning_max',
        'temperature_danger_min',
        'ph_normal_min',
        'ph_normal_max',
        'ph_warning_min',
        'ph_warning_max',
        'ph_danger_min',
        'turbidity_very_clear_max',
        'turbidity_clear_max',
        'turbidity_turbid_max',
    ];
}
