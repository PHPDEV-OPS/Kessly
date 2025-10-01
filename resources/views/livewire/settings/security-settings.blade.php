<div>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Security Settings</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Configure security policies, authentication requirements, and access controls.
            </p>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="save">
            <!-- Password Policy -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Password Policy</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Minimum Password Length</flux:label>
                                <flux:input wire:model="password_min_length" type="number" min="6" max="128" />
                                <flux:error name="password_min_length" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Password Expiry (days)</flux:label>
                                <flux:input wire:model="password_expiry_days" type="number" min="1" max="365" />
                                <flux:description>Leave empty for no expiry</flux:description>
                                <flux:error name="password_expiry_days" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Password History Limit</flux:label>
                                <flux:input wire:model="password_history_limit" type="number" min="0" max="24" />
                                <flux:description>Number of previous passwords to remember</flux:description>
                                <flux:error name="password_history_limit" />
                            </flux:field>
                        </div>

                        <div class="space-y-3">
                            <flux:field>
                                <flux:label>Password Requirements</flux:label>
                                <div class="space-y-2">
                                    <flux:checkbox wire:model="password_require_uppercase">
                                        Require uppercase letters
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="password_require_lowercase">
                                        Require lowercase letters
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="password_require_numbers">
                                        Require numbers
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="password_require_symbols">
                                        Require special symbols
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Management -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Session Management</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Session Timeout (minutes)</flux:label>
                                <flux:input wire:model="session_timeout" type="number" min="5" max="1440" />
                                <flux:description>Automatically log out inactive users</flux:description>
                                <flux:error name="session_timeout" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Concurrent Sessions</flux:label>
                                <flux:input wire:model="concurrent_sessions" type="number" min="1" max="10" />
                                <flux:description>Maximum sessions per user</flux:description>
                                <flux:error name="concurrent_sessions" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Remember Me Duration (days)</flux:label>
                                <flux:input wire:model="remember_me_duration" type="number" min="1" max="365" />
                                <flux:error name="remember_me_duration" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Remember Me Feature</flux:label>
                                <flux:checkbox wire:model="remember_me_enabled">
                                    Enable "Remember Me" option
                                </flux:checkbox>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authentication & Access -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Authentication & Access</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-3">
                            <flux:field>
                                <flux:label>Security Features</flux:label>
                                <div class="space-y-2">
                                    <flux:checkbox wire:model="two_factor_required">
                                        Require Two-Factor Authentication
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="email_verification_required">
                                        Require Email Verification
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="login_notification_enabled">
                                        Send Login Notifications
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="suspicious_activity_detection">
                                        Detect Suspicious Activity
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>IP Whitelisting</flux:label>
                                <flux:checkbox wire:model="ip_whitelist_enabled">
                                    Enable IP Whitelisting
                                </flux:checkbox>
                                @if($ip_whitelist_enabled)
                                    <flux:textarea wire:model="allowed_ips" rows="3" class="mt-2" />
                                    <flux:description>Enter allowed IP addresses, one per line</flux:description>
                                    <flux:error name="allowed_ips" />
                                @endif
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Lockout -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Account Lockout Policy</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Account Lockout</flux:label>
                                <flux:checkbox wire:model="account_lockout_enabled">
                                    Enable automatic account lockout
                                </flux:checkbox>
                            </flux:field>
                        </div>

                        @if($account_lockout_enabled)
                            <div>
                                <flux:field>
                                    <flux:label>Max Failed Attempts</flux:label>
                                    <flux:input wire:model="max_failed_attempts" type="number" min="1" max="20" />
                                    <flux:error name="max_failed_attempts" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Lockout Duration (minutes)</flux:label>
                                    <flux:input wire:model="lockout_duration_minutes" type="number" min="1" max="1440" />
                                    <flux:error name="lockout_duration_minutes" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Reset Failed Attempts After (minutes)</flux:label>
                                    <flux:input wire:model="reset_failed_attempts_after" type="number" min="1" max="1440" />
                                    <flux:description>Reset counter after this period of no failed attempts</flux:description>
                                    <flux:error name="reset_failed_attempts_after" />
                                </flux:field>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- API Security -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">API Security</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Rate Limiting</flux:label>
                                <flux:checkbox wire:model="api_rate_limit_enabled">
                                    Enable API rate limiting
                                </flux:checkbox>
                            </flux:field>
                        </div>

                        @if($api_rate_limit_enabled)
                            <div>
                                <flux:field>
                                    <flux:label>Requests Per Minute</flux:label>
                                    <flux:input wire:model="api_requests_per_minute" type="number" min="1" max="10000" />
                                    <flux:error name="api_requests_per_minute" />
                                </flux:field>
                            </div>
                        @endif

                        <div>
                            <flux:field>
                                <flux:label>API Key Expiry (days)</flux:label>
                                <flux:input wire:model="api_key_expiry_days" type="number" min="1" max="365" />
                                <flux:error name="api_key_expiry_days" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>CORS</flux:label>
                                <flux:checkbox wire:model="cors_enabled">
                                    Enable CORS
                                </flux:checkbox>
                                @if($cors_enabled)
                                    <flux:textarea wire:model="allowed_origins" rows="2" class="mt-2" />
                                    <flux:description>Allowed origins, one per line (* for all)</flux:description>
                                    <flux:error name="allowed_origins" />
                                @endif
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-between">
                <flux:button type="button" variant="ghost" wire:click="resetToDefaults">
                    Reset to Defaults
                </flux:button>
                
                <div class="flex space-x-3">
                    <flux:button type="button" variant="outline" wire:click="loadSettings">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Save Security Settings
                    </flux:button>
                </div>
            </div>
        </form>
    </div>
</div>