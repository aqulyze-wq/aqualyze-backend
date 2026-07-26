<?php

namespace App\Http\Controllers;

use App\Models\RuleEngine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RuleEngineController extends Controller
{
    public function index(): View
    {
        $ruleEngine = RuleEngine::latest()->first();

        return view('rule-engine.index', compact('ruleEngine'))->with('pageTitle', 'Rule Engine');
    }

    public function update(Request $request): RedirectResponse
    {
        // Validasi sederhana: Cukup pastikan input berupa angka tanpa aturan urutan/logika
        $validated = $request->validate([
            'temperature_normal_min'  => 'required|numeric',
            'temperature_normal_max'  => 'required|numeric',
            'temperature_warning_min' => 'required|numeric',
            'temperature_warning_max' => 'required|numeric',
            'temperature_danger_min'  => 'required|numeric',

            'ph_normal_min'  => 'required|numeric',
            'ph_normal_max'  => 'required|numeric',
            'ph_warning_min' => 'required|numeric',
            'ph_warning_max' => 'required|numeric',
            'ph_danger_min'  => 'required|numeric',

            'turbidity_very_clear_max' => 'required|numeric',
            'turbidity_clear_max'      => 'required|numeric',
            'turbidity_turbid_max'     => 'required|numeric',
        ]);

        // Gunakan updateOrCreate/firstOrCreate untuk mencegah error jika database kosong
        $ruleEngine = RuleEngine::first();

        if (!$ruleEngine) {
            RuleEngine::create($validated);
        } else {
            $ruleEngine->update($validated);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}