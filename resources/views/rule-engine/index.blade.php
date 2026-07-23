@extends('layouts.app')

@section('content')

<div class="aq-page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1>Rule Engine</h1>
        <p>Configure threshold values used to classify sensor readings.</p>
    </div>
</div>

@if(session('success'))
    <div class="aq-alert aq-alert-success mb-4">
        <i class="bi bi-check-circle-fill aq-alert-icon"></i>
        <div class="aq-alert-text">{{ session('success') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="aq-alert aq-alert-warning mb-4">
        <i class="bi bi-exclamation-triangle-fill aq-alert-icon"></i>
        <div class="aq-alert-text">
            Please correct the highlighted values and try again.
        </div>
    </div>
@endif

<form method="POST" action="{{ route('rule-engine.update') }}" novalidate>
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="aq-card h-100 border-0 shadow-sm">
                <div class="aq-card-header pb-3">
                    <div>
                        <span class="aq-card-title">Temperature Threshold</span>
                        <div class="text-muted small mt-1">Configure temperature classification.</div>
                    </div>
                </div>
                <div class="aq-card-body pt-0">
                    <div class="mb-3">
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Normal</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="temperature_normal_min">Min</label>
                                    <input type="number" step="0.01" name="temperature_normal_min" id="temperature_normal_min" class="aq-input @error('temperature_normal_min') error @enderror" value="{{ old('temperature_normal_min', $ruleEngine->temperature_normal_min ?? 25) }}" required>
                                    @error('temperature_normal_min')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="temperature_normal_max">Max</label>
                                    <input type="number" step="0.01" name="temperature_normal_max" id="temperature_normal_max" class="aq-input @error('temperature_normal_max') error @enderror" value="{{ old('temperature_normal_max', $ruleEngine->temperature_normal_max ?? 30) }}" required>
                                    @error('temperature_normal_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Warning</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="temperature_warning_min">Min</label>
                                    <input type="number" step="0.01" name="temperature_warning_min" id="temperature_warning_min" class="aq-input @error('temperature_warning_min') error @enderror" value="{{ old('temperature_warning_min', $ruleEngine->temperature_warning_min ?? 30) }}" required>
                                    @error('temperature_warning_min')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="temperature_warning_max">Max</label>
                                    <input type="number" step="0.01" name="temperature_warning_max" id="temperature_warning_max" class="aq-input @error('temperature_warning_max') error @enderror" value="{{ old('temperature_warning_max', $ruleEngine->temperature_warning_max ?? 32) }}" required>
                                    @error('temperature_warning_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Danger</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="temperature_danger_min">Min</label>
                                    <input type="number" step="0.01" name="temperature_danger_min" id="temperature_danger_min" class="aq-input @error('temperature_danger_min') error @enderror" value="{{ old('temperature_danger_min', $ruleEngine->temperature_danger_min ?? 32) }}" required>
                                    @error('temperature_danger_min')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-muted small mt-3">Unit: °C</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="aq-card h-100 border-0 shadow-sm">
                <div class="aq-card-header pb-3">
                    <div>
                        <span class="aq-card-title">pH Threshold</span>
                        <div class="text-muted small mt-1">Configure pH classification.</div>
                    </div>
                </div>
                <div class="aq-card-body pt-0">
                    <div class="mb-3">
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Normal</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="ph_normal_min">Min</label>
                                    <input type="number" step="0.01" name="ph_normal_min" id="ph_normal_min" class="aq-input @error('ph_normal_min') error @enderror" value="{{ old('ph_normal_min', $ruleEngine->ph_normal_min ?? 6.5) }}" required>
                                    @error('ph_normal_min')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="ph_normal_max">Max</label>
                                    <input type="number" step="0.01" name="ph_normal_max" id="ph_normal_max" class="aq-input @error('ph_normal_max') error @enderror" value="{{ old('ph_normal_max', $ruleEngine->ph_normal_max ?? 8.5) }}" required>
                                    @error('ph_normal_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Warning</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="ph_warning_min">Min</label>
                                    <input type="number" step="0.01" name="ph_warning_min" id="ph_warning_min" class="aq-input @error('ph_warning_min') error @enderror" value="{{ old('ph_warning_min', $ruleEngine->ph_warning_min ?? 6.0) }}" required>
                                    @error('ph_warning_min')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="ph_warning_max">Max</label>
                                    <input type="number" step="0.01" name="ph_warning_max" id="ph_warning_max" class="aq-input @error('ph_warning_max') error @enderror" value="{{ old('ph_warning_max', $ruleEngine->ph_warning_max ?? 6.5) }}" required>
                                    @error('ph_warning_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Danger</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="ph_danger_min">Min</label>
                                    <input type="number" step="0.01" name="ph_danger_min" id="ph_danger_min" class="aq-input @error('ph_danger_min') error @enderror" value="{{ old('ph_danger_min', $ruleEngine->ph_danger_min ?? 6.0) }}" required>
                                    @error('ph_danger_min')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="aq-card h-100 border-0 shadow-sm">
                <div class="aq-card-header pb-3">
                    <div>
                        <span class="aq-card-title">Turbidity Threshold</span>
                        <div class="text-muted small mt-1">Configure turbidity classification.</div>
                    </div>
                </div>
                <div class="aq-card-body pt-0">
                    <div class="mb-3">
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Very Clear</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="turbidity_very_clear_max">Max</label>
                                    <input type="number" step="0.01" name="turbidity_very_clear_max" id="turbidity_very_clear_max" class="aq-input @error('turbidity_very_clear_max') error @enderror" value="{{ old('turbidity_very_clear_max', $ruleEngine->turbidity_very_clear_max ?? 5) }}" required>
                                    @error('turbidity_very_clear_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Clear</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="turbidity_clear_max">Max</label>
                                    <input type="number" step="0.01" name="turbidity_clear_max" id="turbidity_clear_max" class="aq-input @error('turbidity_clear_max') error @enderror" value="{{ old('turbidity_clear_max', $ruleEngine->turbidity_clear_max ?? 20) }}" required>
                                    @error('turbidity_clear_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="fw-semibold text-secondary small text-uppercase mb-2">Turbid</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="aq-form-group mb-0">
                                    <label class="aq-label" for="turbidity_turbid_max">Max</label>
                                    <input type="number" step="0.01" name="turbidity_turbid_max" id="turbidity_turbid_max" class="aq-input @error('turbidity_turbid_max') error @enderror" value="{{ old('turbidity_turbid_max', $ruleEngine->turbidity_turbid_max ?? 50) }}" required>
                                    @error('turbidity_turbid_max')<div class="aq-input-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-muted small mt-3">Unit: NTU</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('dashboard') }}" class="aq-btn aq-btn-outline">Cancel</a>
        <button type="submit" class="aq-btn aq-btn-primary">Save Changes</button>
    </div>
</form>

@endsection
