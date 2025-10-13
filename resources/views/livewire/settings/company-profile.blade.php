<div>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Company Profile</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage your company information, branding, and business details.
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
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Company Name *</flux:label>
                                <flux:input wire:model="company_name" />
                                <flux:error name="company_name" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Email Address</flux:label>
                                <flux:input wire:model="company_email" type="email" />
                                <flux:error name="company_email" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Phone Number</flux:label>
                                <flux:input wire:model="company_phone" />
                                <flux:error name="company_phone" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Website</flux:label>
                                <flux:input wire:model="company_website" type="url" />
                                <flux:error name="company_website" />
                            </flux:field>
                        </div>

                        <div class="sm:col-span-2">
                            <flux:field>
                                <flux:label>Company Description</flux:label>
                                <flux:textarea wire:model="company_description" rows="3" />
                                <flux:description>Brief description of your company</flux:description>
                                <flux:error name="company_description" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Company Slogan</flux:label>
                                <flux:input wire:model="company_slogan" />
                                <flux:error name="company_slogan" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Address Information</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <flux:field>
                                <flux:label>Street Address</flux:label>
                                <flux:textarea wire:model="company_address" rows="2" />
                                <flux:error name="company_address" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>City</flux:label>
                                <flux:input wire:model="company_city" />
                                <flux:error name="company_city" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>State/Province</flux:label>
                                <flux:input wire:model="company_state" />
                                <flux:error name="company_state" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Postal Code</flux:label>
                                <flux:input wire:model="company_postal_code" />
                                <flux:error name="company_postal_code" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Country</flux:label>
                                <flux:input wire:model="company_country" />
                                <flux:error name="company_country" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Information -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Information</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Tax Number</flux:label>
                                <flux:input wire:model="tax_number" />
                                <flux:error name="tax_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Registration Number</flux:label>
                                <flux:input wire:model="registration_number" />
                                <flux:error name="registration_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>VAT Number</flux:label>
                                <flux:input wire:model="vat_number" />
                                <flux:error name="vat_number" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Industry</flux:label>
                                <flux:select wire:model="industry">
                                    <option value="">Select an industry...</option>
                                    @foreach($this->getIndustries() as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </flux:select>
                                <flux:error name="industry" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Company Size</flux:label>
                                <flux:select wire:model="company_size">
                                    <option value="">Select company size...</option>
                                    @foreach($this->getCompanySizes() as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </flux:select>
                                <flux:error name="company_size" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Founded Year</flux:label>
                                <flux:input wire:model="founded_year" type="number" min="1800" max="{{ date('Y') }}" />
                                <flux:error name="founded_year" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branding -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Branding</h4>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <flux:field>
                                <flux:label>Company Logo</flux:label>
                                <flux:input wire:model="logo" type="file" accept="image/*" />
                                <flux:description>Upload a logo for your company (max 2MB)</flux:description>
                                <flux:error name="logo" />
                                
                                <!-- Current Logo -->
                                @if ($company_logo)
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Logo:</p>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('storage/' . $company_logo) }}" alt="Current Logo" class="h-16 w-auto border rounded-lg shadow-sm">
                                            <flux:button variant="danger" size="sm" wire:click="removeLogo" type="button">
                                                Remove Logo
                                            </flux:button>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Preview New Logo -->
                                @if ($logo)
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Logo Preview:</p>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="h-16 w-auto border rounded-lg shadow-sm">
                                            <flux:button variant="outline" size="sm" wire:click="clearLogoUpload" type="button">
                                                Clear
                                            </flux:button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">This logo will be saved when you submit the form</p>
                                    </div>
                                @endif
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Login Background Image</flux:label>
                                <flux:input wire:model="background_image" type="file" accept="image/*" />
                                <flux:description>Upload a background image for login pages (max 5MB)</flux:description>
                                <flux:error name="background_image" />
                                
                                <!-- Current Background Image -->
                                @if ($company_background_image)
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Background Image:</p>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('storage/' . $company_background_image) }}" alt="Current Background" class="h-24 w-32 object-cover rounded-lg border shadow-sm">
                                            <flux:button variant="danger" size="sm" wire:click="removeBackgroundImage" type="button">
                                                Remove Background
                                            </flux:button>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Preview New Background Image -->
                                @if ($background_image)
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Background Preview:</p>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $background_image->temporaryUrl() }}" alt="Background Preview" class="h-24 w-32 object-cover rounded-lg border shadow-sm">
                                            <flux:button variant="outline" size="sm" wire:click="clearBackgroundImageUpload" type="button">
                                                Clear
                                            </flux:button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">This background will be saved when you submit the form</p>
                                    </div>
                                @endif
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Financial Information</h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <flux:field>
                                <flux:label>Bank Name</flux:label>
                                <flux:input wire:model="bank_name" />
                                <flux:error name="bank_name" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Bank Account</flux:label>
                                <flux:input wire:model="bank_account" />
                                <flux:error name="bank_account" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>SWIFT Code</flux:label>
                                <flux:input wire:model="swift_code" />
                                <flux:error name="swift_code" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>IBAN</flux:label>
                                <flux:input wire:model="iban" />
                                <flux:error name="iban" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end">
                <flux:button type="submit" variant="primary">
                    Save Company Profile
                </flux:button>
            </div>
        </form>
    </div>
</div>
