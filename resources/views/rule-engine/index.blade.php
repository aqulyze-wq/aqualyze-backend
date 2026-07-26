@extends('layouts.app')

@section('content')

<style>
    .re-container { padding: 10px 0; }
    .re-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .re-title h1 { font-size: 24px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0; }
    .re-title p { font-size: 14px; color: #64748b; margin: 0; }
    .re-btn-save {
        background: #0284c7;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
    }
    .re-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }
    .re-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
    }
    .re-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .re-card-title h3 { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0; }
    .re-zone {
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 14px;
        background: #f8fafc;
    }
    .re-zone-normal { border-left: 4px solid #10b981; background: #f0fdf4; }
    .re-zone-warning { border-left: 4px solid #f59e0b; background: #fffbeb; }
    .re-zone-danger { border-left: 4px solid #ef4444; background: #fef2f2; }
    .re-input-group { display: flex; gap: 10px; }
    .re-input-box { flex: 1; }
    .re-input-box label { display: block; font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 4px; }
    .re-input-box input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        outline: none;
    }
</style>

<div class="re-container">
    <form action="{{ route('rule-engine.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="re-header">
            <div class="re-title">
                <h1>Rule Engine & Thresholds</h1>
                <p>Pengaturan nilai batas ambang sensor.</p>
            </div>
            <button type="submit" class="re-btn-save">
                <i class="bi bi-floppy-fill"></i> Simpan
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4" style="border-radius: 12px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="re-grid">

            <!-- CARD 1: TEMPERATURE -->
            <div class="re-card">
                <div class="re-card-header">
                    <div class="re-card-title">
                        <h3>Temperature (°C)</h3>
                    </div>
                </div>

                <div class="re-zone re-zone-normal">
                    <strong>Normal Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Min</label>
                            <input type="number" step="any" name="temperature_normal_min" value="{{ old('temperature_normal_min', $ruleEngine->temperature_normal_min ?? '') }}">
                        </div>
                        <div class="re-input-box">
                            <label>Max</label>
                            <input type="number" step="any" name="temperature_normal_max" value="{{ old('temperature_normal_max', $ruleEngine->temperature_normal_max ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="re-zone re-zone-warning">
                    <strong>Warning Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Min</label>
                            <input type="number" step="any" name="temperature_warning_min" value="{{ old('temperature_warning_min', $ruleEngine->temperature_warning_min ?? '') }}">
                        </div>
                        <div class="re-input-box">
                            <label>Max</label>
                            <input type="number" step="any" name="temperature_warning_max" value="{{ old('temperature_warning_max', $ruleEngine->temperature_warning_max ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="re-zone re-zone-danger">
                    <strong>Danger Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Min Danger</label>
                            <input type="number" step="any" name="temperature_danger_min" value="{{ old('temperature_danger_min', $ruleEngine->temperature_danger_min ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: pH LEVEL -->
            <div class="re-card">
                <div class="re-card-header">
                    <div class="re-card-title">
                        <h3>pH Level</h3>
                    </div>
                </div>

                <div class="re-zone re-zone-normal">
                    <strong>Normal Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Min</label>
                            <input type="number" step="any" name="ph_normal_min" value="{{ old('ph_normal_min', $ruleEngine->ph_normal_min ?? '') }}">
                        </div>
                        <div class="re-input-box">
                            <label>Max</label>
                            <input type="number" step="any" name="ph_normal_max" value="{{ old('ph_normal_max', $ruleEngine->ph_normal_max ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="re-zone re-zone-warning">
                    <strong>Warning Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Min</label>
                            <input type="number" step="any" name="ph_warning_min" value="{{ old('ph_warning_min', $ruleEngine->ph_warning_min ?? '') }}">
                        </div>
                        <div class="re-input-box">
                            <label>Max</label>
                            <input type="number" step="any" name="ph_warning_max" value="{{ old('ph_warning_max', $ruleEngine->ph_warning_max ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="re-zone re-zone-danger">
                    <strong>Danger Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Min Danger</label>
                            <input type="number" step="any" name="ph_danger_min" value="{{ old('ph_danger_min', $ruleEngine->ph_danger_min ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3: TURBIDITY -->
            <div class="re-card">
                <div class="re-card-header">
                    <div class="re-card-title">
                        <h3>Turbidity (NTU)</h3>
                    </div>
                </div>

                <div class="re-zone re-zone-normal">
                    <strong>Very Clear Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Max NTU</label>
                            <input type="number" step="any" name="turbidity_very_clear_max" value="{{ old('turbidity_very_clear_max', $ruleEngine->turbidity_very_clear_max ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="re-zone re-zone-warning">
                    <strong>Clear Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Max NTU</label>
                            <input type="number" step="any" name="turbidity_clear_max" value="{{ old('turbidity_clear_max', $ruleEngine->turbidity_clear_max ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="re-zone re-zone-danger">
                    <strong>Turbid Zone</strong>
                    <div class="re-input-group mt-2">
                        <div class="re-input-box">
                            <label>Max NTU</label>
                            <input type="number" step="any" name="turbidity_turbid_max" value="{{ old('turbidity_turbid_max', $ruleEngine->turbidity_turbid_max ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection