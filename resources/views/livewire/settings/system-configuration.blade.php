<div>
    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class='bx bx-check-circle me-2'></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class='bx bx-error-circle me-2'></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form wire:submit="save">
        <div class="row g-4">
            <!-- Application Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-cog text-primary me-2'></i>
                            Application Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Application Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="app_name" class="form-control @error('app_name') is-invalid @enderror" placeholder="App Name">
                                @error('app_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Application URL <span class="text-danger">*</span></label>
                                <input type="url" wire:model="app_url" class="form-control @error('app_url') is-invalid @enderror" placeholder="https://example.com">
                                @error('app_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Localization Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-world text-primary me-2'></i>
                            Localization
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Timezone <span class="text-danger">*</span></label>
                                <select wire:model="timezone" class="form-select @error('timezone') is-invalid @enderror">
                                    <option value="">Select Timezone</option>
                                    @foreach($this->getTimezones() as $tz => $label)
                                        <option value="{{ $tz }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('timezone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Language <span class="text-danger">*</span></label>
                                <select wire:model="locale" class="form-select @error('locale') is-invalid @enderror">
                                    @foreach($this->getLocales() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('locale') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currency & Format Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-money text-primary me-2'></i>
                            Currency & Formats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                                <select wire:model="currency" class="form-select @error('currency') is-invalid @enderror">
                                    <option value="KES">Kenyan Shilling (KES)</option>
                                </select>
                                @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Currency Position <span class="text-danger">*</span></label>
                                <select wire:model="currency_position" class="form-select @error('currency_position') is-invalid @enderror">
                                    <option value="before">Before Amount ($100)</option>
                                    <option value="after">After Amount (100$)</option>
                                </select>
                                @error('currency_position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Date Format <span class="text-danger">*</span></label>
                                <select wire:model="date_format" class="form-select @error('date_format') is-invalid @enderror">
                                    @foreach($this->getDateFormats() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('date_format') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Time Format <span class="text-danger">*</span></label>
                                <select wire:model="time_format" class="form-select @error('time_format') is-invalid @enderror">
                                    @foreach($this->getTimeFormats() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('time_format') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Decimal Separator <span class="text-danger">*</span></label>
                                <input type="text" wire:model="decimal_separator" class="form-control @error('decimal_separator') is-invalid @enderror" maxlength="1" placeholder=".">
                                @error('decimal_separator') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Thousands Separator <span class="text-danger">*</span></label>
                                <input type="text" wire:model="thousands_separator" class="form-control @error('thousands_separator') is-invalid @enderror" maxlength="1" placeholder=",">
                                @error('thousands_separator') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Preferences Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-slider text-primary me-2'></i>
                            System Preferences
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Session Lifetime (minutes) <span class="text-danger">*</span></label>
                                <input type="number" wire:model="session_lifetime" class="form-control @error('session_lifetime') is-invalid @enderror" min="1" max="10080">
                                @error('session_lifetime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">How long users stay logged in</small>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Max Login Attempts <span class="text-danger">*</span></label>
                                <input type="number" wire:model="max_login_attempts" class="form-control @error('max_login_attempts') is-invalid @enderror" min="1" max="20">
                                @error('max_login_attempts') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Before account lockout</small>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Lockout Duration (minutes) <span class="text-danger">*</span></label>
                                <input type="number" wire:model="lockout_duration" class="form-control @error('lockout_duration') is-invalid @enderror" min="1" max="1440">
                                @error('lockout_duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Account lock time</small>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="maintenance_mode" id="maintenanceMode">
                                    <label class="form-check-label fw-semibold" for="maintenanceMode">
                                        Maintenance Mode
                                    </label>
                                    <div class="text-muted small">Disable public access temporarily</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="cache_enabled" id="cacheEnabled">
                                    <label class="form-check-label fw-semibold" for="cacheEnabled">
                                        Enable Cache
                                    </label>
                                    <div class="text-muted small">Improve performance with caching</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end flex-column flex-md-row">
                    <button type="button" wire:click="resetToDefaults" class="btn btn-outline-secondary w-100 w-md-auto" wire:loading.attr="disabled">
                        <i class='bx bx-reset me-1'></i>
                        Reset to Defaults
                    </button>
                    <button type="submit" class="btn btn-primary w-100 w-md-auto" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class='bx bx-save me-1'></i>Save Configuration
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
