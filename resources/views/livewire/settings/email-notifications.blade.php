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
            <!-- SMTP Configuration Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-server text-primary me-2'></i>
                            SMTP Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mail Driver</label>
                            <select wire:model="mail_mailer" class="form-select">
                                <option value="smtp">SMTP</option>
                                <option value="sendmail">Sendmail</option>
                                <option value="mailgun">Mailgun</option>
                                <option value="ses">Amazon SES</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">SMTP Host</label>
                            <input type="text" wire:model="mail_host" class="form-control @error('mail_host') is-invalid @enderror" placeholder="smtp.gmail.com">
                            @error('mail_host') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">SMTP Port</label>
                            <input type="number" wire:model="mail_port" class="form-control @error('mail_port') is-invalid @enderror" placeholder="587">
                            @error('mail_port') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">SMTP Username</label>
                            <input type="text" wire:model="mail_username" class="form-control @error('mail_username') is-invalid @enderror" placeholder="user@example.com">
                            @error('mail_username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">SMTP Password</label>
                            <input type="password" wire:model="mail_password" class="form-control @error('mail_password') is-invalid @enderror" placeholder="••••••••">
                            @error('mail_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Encryption</label>
                            <select wire:model="mail_encryption" class="form-select">
                                <option value="">None</option>
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">From Address <span class="text-danger">*</span></label>
                            <input type="email" wire:model="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror" placeholder="noreply@example.com">
                            @error('mail_from_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">From Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="mail_from_name" class="form-control @error('mail_from_name') is-invalid @enderror" placeholder="Kessly">
                            @error('mail_from_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Templates Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-envelope text-primary me-2'></i>
                            Email Templates
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" wire:model="welcome_email_enabled" id="welcomeEmail">
                                <label class="form-check-label fw-semibold" for="welcomeEmail">
                                    Welcome Email
                                </label>
                            </div>
                            @if($welcome_email_enabled)
                                <input type="text" wire:model="welcome_email_subject" class="form-control" placeholder="Subject line">
                            @endif
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" wire:model="order_confirmation_enabled" id="orderEmail">
                                <label class="form-check-label fw-semibold" for="orderEmail">
                                    Order Confirmation
                                </label>
                            </div>
                            @if($order_confirmation_enabled)
                                <input type="text" wire:model="order_confirmation_subject" class="form-control" placeholder="Subject line">
                            @endif
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" wire:model="invoice_email_enabled" id="invoiceEmail">
                                <label class="form-check-label fw-semibold" for="invoiceEmail">
                                    Invoice Email
                                </label>
                            </div>
                            @if($invoice_email_enabled)
                                <input type="text" wire:model="invoice_email_subject" class="form-control" placeholder="Subject line">
                            @endif
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Password Reset Subject</label>
                            <input type="text" wire:model="password_reset_subject" class="form-control" placeholder="Subject line">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Preferences Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-bell text-primary me-2'></i>
                            Notification Preferences
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="notify_new_orders" id="notifyOrders">
                                <label class="form-check-label fw-semibold" for="notifyOrders">
                                    New Orders
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="notify_low_stock" id="notifyStock">
                                <label class="form-check-label fw-semibold" for="notifyStock">
                                    Low Stock Alerts
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="notify_new_users" id="notifyUsers">
                                <label class="form-check-label fw-semibold" for="notifyUsers">
                                    New User Registrations
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="notify_payment_received" id="notifyPayment">
                                <label class="form-check-label fw-semibold" for="notifyPayment">
                                    Payment Received
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="notify_invoice_overdue" id="notifyOverdue">
                                <label class="form-check-label fw-semibold" for="notifyOverdue">
                                    Invoice Overdue
                                </label>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="notify_system_updates" id="notifySystem">
                                <label class="form-check-label fw-semibold" for="notifySystem">
                                    System Updates
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Recipients Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-user-check text-primary me-2'></i>
                            Notification Recipients
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Admin Email <span class="text-danger">*</span></label>
                            <input type="email" wire:model="admin_email" class="form-control @error('admin_email') is-invalid @enderror" placeholder="admin@example.com">
                            @error('admin_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sales Email</label>
                            <input type="email" wire:model="sales_email" class="form-control @error('sales_email') is-invalid @enderror" placeholder="sales@example.com">
                            @error('sales_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Support Email</label>
                            <input type="email" wire:model="support_email" class="form-control @error('support_email') is-invalid @enderror" placeholder="support@example.com">
                            @error('support_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Finance Email</label>
                            <input type="email" wire:model="finance_email" class="form-control @error('finance_email') is-invalid @enderror" placeholder="finance@example.com">
                            @error('finance_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Reports Card -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-bar-chart text-primary me-2'></i>
                            Automated Reports
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="daily_reports_enabled" id="dailyReports">
                                    <label class="form-check-label fw-semibold" for="dailyReports">
                                        Daily Reports
                                    </label>
                                    <div class="text-muted small">Sales summary every day</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="weekly_reports_enabled" id="weeklyReports">
                                    <label class="form-check-label fw-semibold" for="weeklyReports">
                                        Weekly Reports
                                    </label>
                                    <div class="text-muted small">Performance overview weekly</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="monthly_reports_enabled" id="monthlyReports">
                                    <label class="form-check-label fw-semibold" for="monthlyReports">
                                        Monthly Reports
                                    </label>
                                    <div class="text-muted small">Comprehensive monthly analysis</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" wire:click="testEmail" class="btn btn-outline-secondary" wire:loading.attr="disabled">
                        <i class='bx bx-send me-1'></i>
                        Send Test Email
                    </button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class='bx bx-save me-1'></i>Save Email Settings
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
