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
            <!-- Basic Information Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-info-circle text-primary me-2'></i>
                            Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Enter company name">
                                @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" wire:model="company_email" class="form-control @error('company_email') is-invalid @enderror" placeholder="company@example.com">
                                @error('company_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" wire:model="company_phone" class="form-control @error('company_phone') is-invalid @enderror" placeholder="+254 700 000 000">
                                @error('company_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Website</label>
                                <input type="url" wire:model="company_website" class="form-control @error('company_website') is-invalid @enderror" placeholder="https://example.com">
                                @error('company_website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-map text-primary me-2'></i>
                            Address Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Street Address</label>
                                <textarea wire:model="company_address" class="form-control @error('company_address') is-invalid @enderror" rows="2" placeholder="Enter street address"></textarea>
                                @error('company_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">City</label>
                                <input type="text" wire:model="company_city" class="form-control @error('company_city') is-invalid @enderror" placeholder="City">
                                @error('company_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">State/Province</label>
                                <input type="text" wire:model="company_state" class="form-control @error('company_state') is-invalid @enderror" placeholder="State">
                                @error('company_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Postal Code</label>
                                <input type="text" wire:model="company_postal_code" class="form-control @error('company_postal_code') is-invalid @enderror" placeholder="00100">
                                @error('company_postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Country</label>
                                <input type="text" wire:model="company_country" class="form-control @error('company_country') is-invalid @enderror" placeholder="Kenya">
                                @error('company_country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-briefcase text-primary me-2'></i>
                            Business Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Tax Number</label>
                                <input type="text" wire:model="tax_number" class="form-control @error('tax_number') is-invalid @enderror" placeholder="Tax ID">
                                @error('tax_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Registration Number</label>
                                <input type="text" wire:model="registration_number" class="form-control @error('registration_number') is-invalid @enderror" placeholder="Registration No.">
                                @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">VAT Number</label>
                                <input type="text" wire:model="vat_number" class="form-control @error('vat_number') is-invalid @enderror" placeholder="VAT No.">
                                @error('vat_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Industry</label>
                                <select wire:model="industry" class="form-select @error('industry') is-invalid @enderror">
                                    <option value="">Select Industry</option>
                                    @foreach($this->getIndustries() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('industry') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Company Size</label>
                                <select wire:model="company_size" class="form-select @error('company_size') is-invalid @enderror">
                                    <option value="">Select Size</option>
                                    @foreach($this->getCompanySizes() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('company_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Founded Year</label>
                                <input type="number" wire:model="founded_year" class="form-control @error('founded_year') is-invalid @enderror" placeholder="2020" min="1800" max="{{ date('Y') }}">
                                @error('founded_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-money text-primary me-2'></i>
                            Financial Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Name</label>
                                <input type="text" wire:model="bank_name" class="form-control @error('bank_name') is-invalid @enderror" placeholder="Bank Name">
                                @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Number</label>
                                <input type="text" wire:model="bank_account" class="form-control @error('bank_account') is-invalid @enderror" placeholder="Account No.">
                                @error('bank_account') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">SWIFT Code</label>
                                <input type="text" wire:model="swift_code" class="form-control @error('swift_code') is-invalid @enderror" placeholder="SWIFT/BIC">
                                @error('swift_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">IBAN</label>
                                <input type="text" wire:model="iban" class="form-control @error('iban') is-invalid @enderror" placeholder="IBAN">
                                @error('iban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo & Branding Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-image text-primary me-2'></i>
                            Company Logo
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($company_logo)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $company_logo) }}" alt="Company Logo" class="img-thumbnail" style="max-height: 150px;">
                                <div class="mt-2">
                                    <button type="button" wire:click="removeLogo" class="btn btn-sm btn-danger">
                                        <i class='bx bx-trash'></i> Remove Logo
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($logo)
                            <div class="text-center mb-3">
                                <p class="text-muted small mb-2">New Logo Preview:</p>
                                <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="img-thumbnail" style="max-height: 150px;">
                                <div class="mt-2">
                                    <button type="button" wire:click="clearLogoUpload" class="btn btn-sm btn-secondary">
                                        <i class='bx bx-x'></i> Clear
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Logo</label>
                            <input type="file" wire:model="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                            @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Max 2MB (JPEG, PNG, GIF, WebP)</small>
                        </div>

                        <div wire:loading wire:target="logo" class="text-center">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Uploading...</span>
                            </div>
                            <span class="ms-2 text-muted">Uploading...</span>
                        </div>
                    </div>
                </div>

                <!-- Branding Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class='bx bx-palette text-primary me-2'></i>
                            Branding
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Company Slogan</label>
                            <input type="text" wire:model="company_slogan" class="form-control @error('company_slogan') is-invalid @enderror" placeholder="Your tagline">
                            @error('company_slogan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea wire:model="company_description" class="form-control @error('company_description') is-invalid @enderror" rows="4" placeholder="Brief company description"></textarea>
                            @error('company_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class='bx bx-save me-2'></i>Save Company Profile
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
