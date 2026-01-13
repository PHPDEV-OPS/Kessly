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
            <!-- Financial Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-dollar text-primary me-2'></i>
                            Financial Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tax Rate (%) <span class="text-danger">*</span></label>
                                <input type="number" wire:model="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror" step="0.01" min="0" max="100">
                                @error('tax_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tax Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="tax_name" class="form-control @error('tax_name') is-invalid @enderror" placeholder="VAT">
                                @error('tax_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Invoice Prefix <span class="text-danger">*</span></label>
                                <input type="text" wire:model="invoice_prefix" class="form-control @error('invoice_prefix') is-invalid @enderror" placeholder="INV">
                                @error('invoice_prefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Number <span class="text-danger">*</span></label>
                                <input type="number" wire:model="invoice_start_number" class="form-control @error('invoice_start_number') is-invalid @enderror" min="1">
                                @error('invoice_start_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Payment Terms (days) <span class="text-danger">*</span></label>
                                <input type="number" wire:model="payment_terms_days" class="form-control @error('payment_terms_days') is-invalid @enderror" min="0" max="365">
                                @error('payment_terms_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Default payment due period</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Management Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-cart text-primary me-2'></i>
                            Order Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Order Prefix <span class="text-danger">*</span></label>
                                <input type="text" wire:model="order_prefix" class="form-control @error('order_prefix') is-invalid @enderror" placeholder="ORD">
                                @error('order_prefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Number <span class="text-danger">*</span></label>
                                <input type="number" wire:model="order_start_number" class="form-control @error('order_start_number') is-invalid @enderror" min="1">
                                @error('order_start_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Minimum Order Amount <span class="text-danger">*</span></label>
                                <input type="number" wire:model="minimum_order_amount" class="form-control @error('minimum_order_amount') is-invalid @enderror" step="0.01" min="0">
                                @error('minimum_order_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Order Expiry (days) <span class="text-danger">*</span></label>
                                <input type="number" wire:model="order_expiry_days" class="form-control @error('order_expiry_days') is-invalid @enderror" min="1" max="365">
                                @error('order_expiry_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="auto_order_approval" id="autoApproval">
                                    <label class="form-check-label fw-semibold" for="autoApproval">
                                        Auto-approve Orders
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="allow_backorders" id="allowBackorders">
                                    <label class="form-check-label fw-semibold" for="allowBackorders">
                                        Allow Backorders
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-package text-primary me-2'></i>
                            Inventory Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Low Stock Threshold <span class="text-danger">*</span></label>
                                <input type="number" wire:model="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror" min="0">
                                @error('low_stock_threshold') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Out of Stock Threshold <span class="text-danger">*</span></label>
                                <input type="number" wire:model="out_of_stock_threshold" class="form-control @error('out_of_stock_threshold') is-invalid @enderror" min="0">
                                @error('out_of_stock_threshold') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Reorder Point (days) <span class="text-danger">*</span></label>
                                <input type="number" wire:model="reorder_point_days" class="form-control @error('reorder_point_days') is-invalid @enderror" min="1" max="365">
                                @error('reorder_point_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tracking Method</label>
                                <select wire:model="inventory_tracking_method" class="form-select">
                                    <option value="fifo">FIFO (First In, First Out)</option>
                                    <option value="lifo">LIFO (Last In, First Out)</option>
                                    <option value="average">Average Cost</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="auto_reorder_enabled" id="autoReorder">
                                    <label class="form-check-label fw-semibold" for="autoReorder">
                                        Auto Reorder
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="allow_negative_stock" id="negativeStock">
                                    <label class="form-check-label fw-semibold" for="negativeStock">
                                        Allow Negative Stock
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-user-circle text-primary me-2'></i>
                            Customer Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Prefix <span class="text-danger">*</span></label>
                                <input type="text" wire:model="customer_prefix" class="form-control @error('customer_prefix') is-invalid @enderror" placeholder="CUST">
                                @error('customer_prefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Number <span class="text-danger">*</span></label>
                                <input type="number" wire:model="customer_start_number" class="form-control @error('customer_start_number') is-invalid @enderror" min="1">
                                @error('customer_start_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Default Credit Limit <span class="text-danger">*</span></label>
                                <input type="number" wire:model="customer_credit_limit" class="form-control @error('customer_credit_limit') is-invalid @enderror" step="0.01" min="0">
                                @error('customer_credit_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Loyalty Points Rate <span class="text-danger">*</span></label>
                                <input type="number" wire:model="loyalty_points_rate" class="form-control @error('loyalty_points_rate') is-invalid @enderror" step="0.01" min="0" max="100">
                                @error('loyalty_points_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Points per currency unit</small>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="require_customer_approval" id="custApproval">
                                    <label class="form-check-label fw-semibold" for="custApproval">
                                        Require Customer Approval
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="loyalty_program_enabled" id="loyaltyProgram">
                                    <label class="form-check-label fw-semibold" for="loyaltyProgram">
                                        Enable Loyalty Program
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-id-card text-primary me-2'></i>
                            Employee Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Employee Prefix <span class="text-danger">*</span></label>
                                <input type="text" wire:model="employee_prefix" class="form-control @error('employee_prefix') is-invalid @enderror" placeholder="EMP">
                                @error('employee_prefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Number <span class="text-danger">*</span></label>
                                <input type="number" wire:model="employee_start_number" class="form-control @error('employee_start_number') is-invalid @enderror" min="1">
                                @error('employee_start_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Work Hours/Day <span class="text-danger">*</span></label>
                                <input type="number" wire:model="default_work_hours_per_day" class="form-control @error('default_work_hours_per_day') is-invalid @enderror" step="0.5" min="1" max="24">
                                @error('default_work_hours_per_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Work Days/Week <span class="text-danger">*</span></label>
                                <input type="number" wire:model="default_work_days_per_week" class="form-control @error('default_work_days_per_week') is-invalid @enderror" min="1" max="7">
                                @error('default_work_days_per_week') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Overtime Multiplier <span class="text-danger">*</span></label>
                                <input type="number" wire:model="overtime_rate_multiplier" class="form-control @error('overtime_rate_multiplier') is-invalid @enderror" step="0.1" min="1" max="5">
                                @error('overtime_rate_multiplier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Leave Accrual Rate <span class="text-danger">*</span></label>
                                <input type="number" wire:model="leave_accrual_rate" class="form-control @error('leave_accrual_rate') is-invalid @enderror" step="0.1" min="0" max="10">
                                @error('leave_accrual_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Days per month</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reporting Settings Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-bar-chart text-primary me-2'></i>
                            Reporting Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Fiscal Year Start <span class="text-danger">*</span></label>
                                <select wire:model="fiscal_year_start" class="form-select @error('fiscal_year_start') is-invalid @enderror">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                @error('fiscal_year_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Decimal Places <span class="text-danger">*</span></label>
                                <select wire:model="decimal_places" class="form-select @error('decimal_places') is-invalid @enderror">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @error('decimal_places') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="show_zero_amounts" id="showZero">
                                    <label class="form-check-label fw-semibold" for="showZero">
                                        Show Zero Amounts in Reports
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class='bx bx-save me-1'></i>Save Business Rules
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
