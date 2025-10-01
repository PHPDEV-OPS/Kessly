<div>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Email & Notifications</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Configure email settings, notification preferences, and communication templates.
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
            <!-- SMTP Configuration -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Mail Server Configuration</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Mail Driver</flux:label>
                                <flux:select wire:model="mail_mailer">
                                    @foreach($this->getMailers() as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </flux:select>
                            </flux:field>
                        </div>

                        @if($mail_mailer === 'smtp')
                            <div>
                                <flux:field>
                                    <flux:label>SMTP Host</flux:label>
                                    <flux:input wire:model="mail_host" />
                                    <flux:error name="mail_host" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>SMTP Port</flux:label>
                                    <flux:input wire:model="mail_port" type="number" min="1" max="65535" />
                                    <flux:error name="mail_port" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Encryption</flux:label>
                                    <flux:select wire:model="mail_encryption">
                                        <option value="">None</option>
                                        <option value="tls">TLS</option>
                                        <option value="ssl">SSL</option>
                                    </flux:select>
                                    <flux:error name="mail_encryption" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Username</flux:label>
                                    <flux:input wire:model="mail_username" />
                                    <flux:error name="mail_username" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Password</flux:label>
                                    <flux:input wire:model="mail_password" type="password" />
                                    <flux:description>Leave empty to keep existing password</flux:description>
                                    <flux:error name="mail_password" />
                                </flux:field>
                            </div>
                        @endif

                        <div>
                            <flux:field>
                                <flux:label>From Email Address</flux:label>
                                <flux:input wire:model="mail_from_address" type="email" />
                                <flux:error name="mail_from_address" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>From Name</flux:label>
                                <flux:input wire:model="mail_from_name" />
                                <flux:error name="mail_from_name" />
                            </flux:field>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <flux:button type="button" variant="outline" wire:click="testEmail">
                            Send Test Email
                        </flux:button>
                    </div>
                </div>
            </div>

            <!-- Email Templates -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Email Templates</h4>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <flux:field>
                                    <flux:label>Welcome Email</flux:label>
                                    <flux:checkbox wire:model="welcome_email_enabled">
                                        Send welcome email to new users
                                    </flux:checkbox>
                                    @if($welcome_email_enabled)
                                        <flux:input wire:model="welcome_email_subject" class="mt-2" />
                                        <flux:error name="welcome_email_subject" />
                                    @endif
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Order Confirmation</flux:label>
                                    <flux:checkbox wire:model="order_confirmation_enabled">
                                        Send order confirmation emails
                                    </flux:checkbox>
                                    @if($order_confirmation_enabled)
                                        <flux:input wire:model="order_confirmation_subject" class="mt-2" />
                                        <flux:error name="order_confirmation_subject" />
                                    @endif
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Invoice Email</flux:label>
                                    <flux:checkbox wire:model="invoice_email_enabled">
                                        Send invoice emails
                                    </flux:checkbox>
                                    @if($invoice_email_enabled)
                                        <flux:input wire:model="invoice_email_subject" class="mt-2" />
                                        <flux:error name="invoice_email_subject" />
                                    @endif
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Password Reset Subject</flux:label>
                                    <flux:input wire:model="password_reset_subject" />
                                    <flux:error name="password_reset_subject" />
                                </flux:field>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Recipients -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Notification Recipients</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Admin Email *</flux:label>
                                <flux:input wire:model="admin_email" type="email" />
                                <flux:description>Primary administrator email for system notifications</flux:description>
                                <flux:error name="admin_email" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Sales Team Email</flux:label>
                                <flux:input wire:model="sales_email" type="email" />
                                <flux:description>Email for order and sales notifications</flux:description>
                                <flux:error name="sales_email" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Support Team Email</flux:label>
                                <flux:input wire:model="support_email" type="email" />
                                <flux:description>Email for customer support notifications</flux:description>
                                <flux:error name="support_email" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Finance Team Email</flux:label>
                                <flux:input wire:model="finance_email" type="email" />
                                <flux:description>Email for financial and invoice notifications</flux:description>
                                <flux:error name="finance_email" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Notification Preferences</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Business Notifications</flux:label>
                                <div class="space-y-2 mt-2">
                                    <flux:checkbox wire:model="notify_new_orders">
                                        New orders
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="notify_low_stock">
                                        Low stock alerts
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="notify_payment_received">
                                        Payment received
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="notify_invoice_overdue">
                                        Overdue invoices
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>System Notifications</flux:label>
                                <div class="space-y-2 mt-2">
                                    <flux:checkbox wire:model="notify_new_users">
                                        New user registrations
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="notify_system_updates">
                                        System updates
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="backup_notifications">
                                        Backup status
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="error_notifications">
                                        System errors
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="security_notifications">
                                        Security alerts
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Notifications -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Automated Reports</h4>
                    
                    <div class="space-y-4">
                        <flux:field>
                            <flux:label>Report Frequency</flux:label>
                            <div class="space-y-2 mt-2">
                                <flux:checkbox wire:model="daily_reports_enabled">
                                    Send daily reports
                                </flux:checkbox>
                                <flux:checkbox wire:model="weekly_reports_enabled">
                                    Send weekly reports
                                </flux:checkbox>
                                <flux:checkbox wire:model="monthly_reports_enabled">
                                    Send monthly reports
                                </flux:checkbox>
                            </div>
                        </flux:field>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end space-x-3">
                <flux:button type="button" variant="outline" wire:click="loadSettings">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Save Email Settings
                </flux:button>
            </div>
        </form>
    </div>
</div>