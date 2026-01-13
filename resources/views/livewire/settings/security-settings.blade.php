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
            <!-- Password Policies Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-lock-alt text-primary me-2'></i>
                            Password Policies
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Minimum Length <span class="text-danger">*</span></label>
                            <input type="number" wire:model="password_min_length" class="form-control @error('password_min_length') is-invalid @enderror" min="6" max="128">
                            @error('password_min_length') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="password_require_uppercase" id="reqUppercase">
                                <label class="form-check-label fw-semibold" for="reqUppercase">
                                    Require Uppercase Letters
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="password_require_lowercase" id="reqLowercase">
                                <label class="form-check-label fw-semibold" for="reqLowercase">
                                    Require Lowercase Letters
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="password_require_numbers" id="reqNumbers">
                                <label class="form-check-label fw-semibold" for="reqNumbers">
                                    Require Numbers
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="password_require_symbols" id="reqSymbols">
                                <label class="form-check-label fw-semibold" for="reqSymbols">
                                    Require Special Characters
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Expiry (days)</label>
                            <input type="number" wire:model="password_expiry_days" class="form-control @error('password_expiry_days') is-invalid @enderror" placeholder="Leave empty for no expiry">
                            @error('password_expiry_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Force password change after this many days</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Password History Limit</label>
                            <input type="number" wire:model="password_history_limit" class="form-control @error('password_history_limit') is-invalid @enderror" min="0" max="24">
                            @error('password_history_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Prevent reusing last N passwords</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-time text-primary me-2'></i>
                            Session Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Session Timeout (minutes) <span class="text-danger">*</span></label>
                            <input type="number" wire:model="session_timeout" class="form-control @error('session_timeout') is-invalid @enderror" min="5" max="1440">
                            @error('session_timeout') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Auto logout after inactivity</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Concurrent Sessions <span class="text-danger">*</span></label>
                            <input type="number" wire:model="concurrent_sessions" class="form-control @error('concurrent_sessions') is-invalid @enderror" min="1" max="10">
                            @error('concurrent_sessions') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Max active sessions per user</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="remember_me_enabled" id="rememberMe">
                                <label class="form-check-label fw-semibold" for="rememberMe">
                                    Enable "Remember Me"
                                </label>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Remember Me Duration (days) <span class="text-danger">*</span></label>
                            <input type="number" wire:model="remember_me_duration" class="form-control @error('remember_me_duration') is-invalid @enderror" min="1" max="365">
                            @error('remember_me_duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Lockout Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-lock-open-alt text-primary me-2'></i>
                            Account Lockout
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="account_lockout_enabled" id="lockoutEnabled">
                                <label class="form-check-label fw-semibold" for="lockoutEnabled">
                                    Enable Account Lockout
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Max Failed Attempts <span class="text-danger">*</span></label>
                            <input type="number" wire:model="max_failed_attempts" class="form-control @error('max_failed_attempts') is-invalid @enderror" min="1" max="20">
                            @error('max_failed_attempts') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lockout Duration (minutes) <span class="text-danger">*</span></label>
                            <input type="number" wire:model="lockout_duration_minutes" class="form-control @error('lockout_duration_minutes') is-invalid @enderror" min="1" max="1440">
                            @error('lockout_duration_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Reset Counter After (minutes) <span class="text-danger">*</span></label>
                            <input type="number" wire:model="reset_failed_attempts_after" class="form-control @error('reset_failed_attempts_after') is-invalid @enderror" min="1" max="1440">
                            @error('reset_failed_attempts_after') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Reset failed attempts counter</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Features Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-shield text-primary me-2'></i>
                            Security Features
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="two_factor_required" id="twoFactor">
                                <label class="form-check-label fw-semibold" for="twoFactor">
                                    Require Two-Factor Authentication
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="email_verification_required" id="emailVerify">
                                <label class="form-check-label fw-semibold" for="emailVerify">
                                    Require Email Verification
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="login_notification_enabled" id="loginNotify">
                                <label class="form-check-label fw-semibold" for="loginNotify">
                                    Login Notifications
                                </label>
                                <div class="text-muted small">Email users on new login</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="suspicious_activity_detection" id="suspiciousActivity">
                                <label class="form-check-label fw-semibold" for="suspiciousActivity">
                                    Suspicious Activity Detection
                                </label>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="ip_whitelist_enabled" id="ipWhitelist">
                                <label class="form-check-label fw-semibold" for="ipWhitelist">
                                    IP Whitelist
                                </label>
                            </div>
                            @if($ip_whitelist_enabled)
                                <div class="mt-2">
                                    <textarea wire:model="allowed_ips" class="form-control" rows="3" placeholder="Enter allowed IPs (one per line)"></textarea>
                                    <small class="text-muted">One IP address per line</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class='bx bx-save me-1'></i>Save Security Settings
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
