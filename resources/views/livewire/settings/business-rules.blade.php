<div>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Business Rules</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Configure business logic, workflows, numbering systems, and operational policies.
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
            <!-- Financial Settings -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Financial Settings</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Default Currency</flux:label>
                                <flux:select wire:model="default_currency">
                                    @foreach($this->getCurrencies() as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </flux:select>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Tax Rate (%)</flux:label>
                                <flux:input wire:model="tax_rate" type="number" step="0.01" min="0" max="100" />
                                <flux:error name="tax_rate" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Tax Name</flux:label>
                                <flux:input wire:model="tax_name" />
                                <flux:error name="tax_name" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Tax Number</flux:label>
                                <flux:input wire:model="tax_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Invoice Prefix</flux:label>
                                <flux:input wire:model="invoice_prefix" />
                                <flux:error name="invoice_prefix" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Invoice Starting Number</flux:label>
                                <flux:input wire:model="invoice_start_number" type="number" min="1" />
                                <flux:error name="invoice_start_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Payment Terms (days)</flux:label>
                                <flux:input wire:model="payment_terms_days" type="number" min="0" max="365" />
                                <flux:error name="payment_terms_days" />
                            </flux:field>
                        </div>

                        <div class="sm:col-span-2">
                            <flux:field>
                                <flux:label>Invoice Terms</flux:label>
                                <flux:textarea wire:model="invoice_terms" rows="2" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Management -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Management</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Order Prefix</flux:label>
                                <flux:input wire:model="order_prefix" />
                                <flux:error name="order_prefix" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Order Starting Number</flux:label>
                                <flux:input wire:model="order_start_number" type="number" min="1" />
                                <flux:error name="order_start_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Minimum Order Amount</flux:label>
                                <flux:input wire:model="minimum_order_amount" type="number" step="0.01" min="0" />
                                <flux:error name="minimum_order_amount" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Order Expiry (days)</flux:label>
                                <flux:input wire:model="order_expiry_days" type="number" min="1" max="365" />
                                <flux:error name="order_expiry_days" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Stock Reservation (minutes)</flux:label>
                                <flux:input wire:model="stock_reservation_minutes" type="number" min="1" max="1440" />
                                <flux:description>How long to reserve stock for pending orders</flux:description>
                                <flux:error name="stock_reservation_minutes" />
                            </flux:field>
                        </div>

                        <div class="space-y-3">
                            <flux:field>
                                <flux:label>Order Options</flux:label>
                                <div class="space-y-2">
                                    <flux:checkbox wire:model="auto_order_approval">
                                        Auto-approve new orders
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="allow_backorders">
                                        Allow backorders when out of stock
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Settings -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Inventory Management</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Low Stock Threshold</flux:label>
                                <flux:input wire:model="low_stock_threshold" type="number" min="0" />
                                <flux:error name="low_stock_threshold" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Out of Stock Threshold</flux:label>
                                <flux:input wire:model="out_of_stock_threshold" type="number" min="0" />
                                <flux:error name="out_of_stock_threshold" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Reorder Point (days)</flux:label>
                                <flux:input wire:model="reorder_point_days" type="number" min="1" max="365" />
                                <flux:description>Days of stock to maintain before reordering</flux:description>
                                <flux:error name="reorder_point_days" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Inventory Tracking Method</flux:label>
                                <flux:select wire:model="inventory_tracking_method">
                                    @foreach($this->getInventoryMethods() as $method => $label)
                                        <option value="{{ $method }}">{{ $label }}</option>
                                    @endforeach
                                </flux:select>
                            </flux:field>
                        </div>

                        <div class="space-y-3">
                            <flux:field>
                                <flux:label>Inventory Options</flux:label>
                                <div class="space-y-2">
                                    <flux:checkbox wire:model="auto_reorder_enabled">
                                        Enable automatic reordering
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="allow_negative_stock">
                                        Allow negative stock levels
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Settings -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Customer Management</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Customer Prefix</flux:label>
                                <flux:input wire:model="customer_prefix" />
                                <flux:error name="customer_prefix" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Customer Starting Number</flux:label>
                                <flux:input wire:model="customer_start_number" type="number" min="1" />
                                <flux:error name="customer_start_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Default Credit Limit</flux:label>
                                <flux:input wire:model="customer_credit_limit" type="number" step="0.01" min="0" />
                                <flux:error name="customer_credit_limit" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Loyalty Points Rate (%)</flux:label>
                                <flux:input wire:model="loyalty_points_rate" type="number" step="0.01" min="0" max="100" />
                                <flux:error name="loyalty_points_rate" />
                            </flux:field>
                        </div>

                        <div class="space-y-3">
                            <flux:field>
                                <flux:label>Customer Options</flux:label>
                                <div class="space-y-2">
                                    <flux:checkbox wire:model="require_customer_approval">
                                        Require admin approval for new customers
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="loyalty_program_enabled">
                                        Enable loyalty program
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Settings -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Employee Management</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Employee Prefix</flux:label>
                                <flux:input wire:model="employee_prefix" />
                                <flux:error name="employee_prefix" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Employee Starting Number</flux:label>
                                <flux:input wire:model="employee_start_number" type="number" min="1" />
                                <flux:error name="employee_start_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Default Work Hours/Day</flux:label>
                                <flux:input wire:model="default_work_hours_per_day" type="number" step="0.5" min="1" max="24" />
                                <flux:error name="default_work_hours_per_day" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Default Work Days/Week</flux:label>
                                <flux:input wire:model="default_work_days_per_week" type="number" min="1" max="7" />
                                <flux:error name="default_work_days_per_week" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Overtime Rate Multiplier</flux:label>
                                <flux:input wire:model="overtime_rate_multiplier" type="number" step="0.1" min="1" max="5" />
                                <flux:error name="overtime_rate_multiplier" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Leave Accrual Rate (days/month)</flux:label>
                                <flux:input wire:model="leave_accrual_rate" type="number" step="0.25" min="0" max="10" />
                                <flux:error name="leave_accrual_rate" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branch Operations -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Branch Operations</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Default Branch ID</flux:label>
                                <flux:input wire:model="default_branch_id" type="number" min="1" />
                            </flux:field>
                        </div>

                        <div class="space-y-3">
                            <flux:field>
                                <flux:label>Branch Features</flux:label>
                                <div class="space-y-2">
                                    <flux:checkbox wire:model="enable_multi_branch">
                                        Enable multi-branch operations
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="inter_branch_transfers">
                                        Allow inter-branch transfers
                                    </flux:checkbox>
                                    <flux:checkbox wire:model="branch_stock_sync">
                                        Synchronize branch stock levels
                                    </flux:checkbox>
                                </div>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reporting Settings -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Reporting Settings</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Fiscal Year Start</flux:label>
                                <flux:select wire:model="fiscal_year_start">
                                    @foreach($this->getMonths() as $month => $name)
                                        <option value="{{ $month }}">{{ $name }}</option>
                                    @endforeach
                                </flux:select>
                                <flux:error name="fiscal_year_start" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Reporting Currency</flux:label>
                                <flux:select wire:model="reporting_currency">
                                    @foreach($this->getCurrencies() as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </flux:select>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Decimal Places</flux:label>
                                <flux:select wire:model="decimal_places">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </flux:select>
                                <flux:error name="decimal_places" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Report Options</flux:label>
                                <flux:checkbox wire:model="show_zero_amounts">
                                    Show zero amounts in reports
                                </flux:checkbox>
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end space-x-3">
                <flux:button type="button" variant="outline" wire:click="loadSettings">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Save Business Rules
                </flux:button>
            </div>
        </form>
    </div>
</div>