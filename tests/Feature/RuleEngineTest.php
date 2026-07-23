<?php

use App\Models\RuleEngine;
use App\Models\User;

describe('Rule Engine', function () {
    it('loads the rule engine page and saves thresholds', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/rule-engine');

        $response->assertOk()
            ->assertSee('Rule Engine')
            ->assertSee('Configure threshold values used to classify sensor readings.');

        $response = $this->actingAs($user)->put('/rule-engine', [
            'temperature_normal_min' => '25',
            'temperature_normal_max' => '30',
            'temperature_warning_min' => '30',
            'temperature_warning_max' => '32',
            'temperature_danger_min' => '32',
            'ph_normal_min' => '6.5',
            'ph_normal_max' => '8.5',
            'ph_warning_min' => '6.0',
            'ph_warning_max' => '6.5',
            'ph_danger_min' => '6.0',
            'turbidity_very_clear_max' => '5',
            'turbidity_clear_max' => '20',
            'turbidity_turbid_max' => '50',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rule_engine', [
            'temperature_normal_min' => 25,
            'temperature_normal_max' => 30,
            'temperature_warning_min' => 30,
            'temperature_warning_max' => 32,
            'temperature_danger_min' => 32,
            'ph_normal_min' => 6.5,
            'ph_normal_max' => 8.5,
            'ph_warning_min' => 6.0,
            'ph_warning_max' => 6.5,
            'ph_danger_min' => 6.0,
            'turbidity_very_clear_max' => 5,
            'turbidity_clear_max' => 20,
            'turbidity_turbid_max' => 50,
        ]);
    });

    it('rejects invalid threshold sequences', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/rule-engine', [
            'temperature_normal_min' => '30',
            'temperature_normal_max' => '25',
            'temperature_warning_min' => '30',
            'temperature_warning_max' => '32',
            'temperature_danger_min' => '32',
            'ph_normal_min' => '6.5',
            'ph_normal_max' => '8.5',
            'ph_warning_min' => '6.0',
            'ph_warning_max' => '6.5',
            'ph_danger_min' => '6.0',
            'turbidity_very_clear_max' => '5',
            'turbidity_clear_max' => '20',
            'turbidity_turbid_max' => '50',
        ]);

        $response->assertSessionHasErrors(['temperature_normal_max']);
    });
});
