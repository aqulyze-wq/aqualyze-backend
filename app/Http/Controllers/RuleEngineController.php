<?php

namespace App\Http\Controllers;

use App\Models\RuleEngine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        $data = $request->validate([
            'temperature_normal_min' => ['required', 'numeric'],
            'temperature_normal_max' => ['required', 'numeric'],
            'temperature_warning_min' => ['required', 'numeric'],
            'temperature_warning_max' => ['required', 'numeric'],
            'temperature_danger_min' => ['required', 'numeric'],
            'ph_normal_min' => ['required', 'numeric'],
            'ph_normal_max' => ['required', 'numeric'],
            'ph_warning_min' => ['required', 'numeric'],
            'ph_warning_max' => ['required', 'numeric'],
            'ph_danger_min' => ['required', 'numeric'],
            'turbidity_very_clear_max' => ['required', 'numeric'],
            'turbidity_clear_max' => ['required', 'numeric'],
            'turbidity_turbid_max' => ['required', 'numeric'],
        ], [
            'required' => 'This field is required.',
            'numeric' => 'This field must be numeric.',
        ]);

        $this->validateThresholds($data);

        $ruleEngine = RuleEngine::latest()->first();

        if (! $ruleEngine) {
            $ruleEngine = new RuleEngine();
        }

        $ruleEngine->fill($data);
        $ruleEngine->save();

        return redirect()->route('rule-engine')->with('success', 'Threshold values updated successfully.');
    }

    protected function validateThresholds(array $data): void
    {
        $rules = [
            ['temperature_normal_min', 'temperature_normal_max', 'Normal minimum cannot be greater than normal maximum.'],
            ['temperature_warning_min', 'temperature_warning_max', 'Warning minimum cannot be greater than warning maximum.'],
            ['ph_normal_min', 'ph_normal_max', 'Normal minimum cannot be greater than normal maximum.'],
            ['ph_warning_min', 'ph_warning_max', 'Warning minimum cannot be greater than warning maximum.'],
            ['turbidity_very_clear_max', 'turbidity_clear_max', 'Very clear maximum cannot be greater than clear maximum.'],
            ['turbidity_clear_max', 'turbidity_turbid_max', 'Clear maximum cannot be greater than turbid maximum.'],
        ];

        foreach ($rules as [$minField, $maxField, $message]) {
            if ((float) $data[$minField] > (float) $data[$maxField]) {
                throw ValidationException::withMessages([
                    $maxField => $message,
                ]);
            }
        }

        $temperatureSequence = [
            ['temperature_normal_min', 'temperature_normal_max', 'Temperature thresholds must be sequential.'],
            ['temperature_normal_max', 'temperature_warning_min', 'Temperature thresholds must be sequential.'],
            ['temperature_warning_min', 'temperature_warning_max', 'Temperature thresholds must be sequential.'],
            ['temperature_warning_max', 'temperature_danger_min', 'Temperature thresholds must be sequential.'],
        ];

        foreach ($temperatureSequence as [$startField, $endField, $message]) {
            if ((float) $data[$startField] > (float) $data[$endField]) {
                throw ValidationException::withMessages([
                    $endField => $message,
                ]);
            }
        }

        $phSequence = [
            ['ph_danger_min', 'ph_warning_min', 'pH thresholds must be sequential.'],
            ['ph_warning_min', 'ph_warning_max', 'pH thresholds must be sequential.'],
            ['ph_warning_max', 'ph_normal_min', 'pH thresholds must be sequential.'],
            ['ph_normal_min', 'ph_normal_max', 'pH thresholds must be sequential.'],
        ];

        foreach ($phSequence as [$startField, $endField, $message]) {
            if ((float) $data[$startField] > (float) $data[$endField]) {
                throw ValidationException::withMessages([
                    $endField => $message,
                ]);
            }
        }

        $turbiditySequence = [
            ['turbidity_very_clear_max', 'turbidity_clear_max', 'Turbidity thresholds must be sequential.'],
            ['turbidity_clear_max', 'turbidity_turbid_max', 'Turbidity thresholds must be sequential.'],
        ];

        foreach ($turbiditySequence as [$startField, $endField, $message]) {
            if ((float) $data[$startField] > (float) $data[$endField]) {
                throw ValidationException::withMessages([
                    $endField => $message,
                ]);
            }
        }
    }
}
