<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyProfile extends Component
{
    use WithFileUploads;

    // Basic Information
    public string $company_name = '';
    public ?string $company_email = null;
    public ?string $company_phone = null;
    public ?string $company_website = null;
    
    // Address Information
    public ?string $company_address = null;
    public ?string $company_city = null;
    public ?string $company_state = null;
    public ?string $company_postal_code = null;
    public ?string $company_country = null;
    
    // Business Information
    public ?string $tax_number = null;
    public ?string $registration_number = null;
    public ?string $vat_number = null;
    public ?string $industry = null;
    public ?string $company_size = null;
    public ?string $founded_year = null;
    
    // Branding
    public $logo;
    public ?string $company_logo = null;
    public ?string $company_description = null;
    public ?string $company_slogan = null;
    
    // Financial Information
    public ?string $bank_name = null;
    public ?string $bank_account = null;
    public ?string $swift_code = null;
    public ?string $iban = null;

    public function mount(): void
    {
        $data = Setting::get('company.profile', []);
        $this->company_name = (string)($data['name'] ?? '');
        $this->company_email = $data['email'] ?? null;
        $this->company_phone = $data['phone'] ?? null;
        $this->company_website = $data['website'] ?? null;
        $this->company_address = $data['address'] ?? null;
        $this->company_city = $data['city'] ?? null;
        $this->company_state = $data['state'] ?? null;
        $this->company_postal_code = $data['postal_code'] ?? null;
        $this->company_country = $data['country'] ?? null;
        $this->tax_number = $data['tax_number'] ?? null;
        $this->registration_number = $data['registration_number'] ?? null;
        $this->vat_number = $data['vat_number'] ?? null;
        $this->industry = $data['industry'] ?? null;
        $this->company_size = $data['company_size'] ?? null;
        $this->founded_year = $data['founded_year'] ?? null;
        $this->company_logo = $data['logo'] ?? null;
        $this->company_description = $data['description'] ?? null;
        $this->company_slogan = $data['slogan'] ?? null;
        $this->bank_name = $data['bank_name'] ?? null;
        $this->bank_account = $data['bank_account'] ?? null;
        $this->swift_code = $data['swift_code'] ?? null;
        $this->iban = $data['iban'] ?? null;
    }

    protected function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'company_city' => ['nullable', 'string', 'max:255'],
            'company_state' => ['nullable', 'string', 'max:255'],
            'company_postal_code' => ['nullable', 'string', 'max:20'],
            'company_country' => ['nullable', 'string', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'vat_number' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string'],
            'founded_year' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'logo' => ['nullable', 'image', 'max:2048'],
            'company_description' => ['nullable', 'string', 'max:1000'],
            'company_slogan' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:255'],
            'swift_code' => ['nullable', 'string', 'max:20'],
            'iban' => ['nullable', 'string', 'max:34'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $logoPath = $this->company_logo;
        
        // Handle logo upload
        if ($this->logo) {
            $logoPath = $this->logo->store('company-logos', 'public');
        }

        Setting::set('company.profile', [
            'name' => $this->company_name,
            'email' => $this->company_email,
            'phone' => $this->company_phone,
            'website' => $this->company_website,
            'address' => $this->company_address,
            'city' => $this->company_city,
            'state' => $this->company_state,
            'postal_code' => $this->company_postal_code,
            'country' => $this->company_country,
            'tax_number' => $this->tax_number,
            'registration_number' => $this->registration_number,
            'vat_number' => $this->vat_number,
            'industry' => $this->industry,
            'company_size' => $this->company_size,
            'founded_year' => $this->founded_year,
            'logo' => $logoPath,
            'description' => $this->company_description,
            'slogan' => $this->company_slogan,
            'bank_name' => $this->bank_name,
            'bank_account' => $this->bank_account,
            'swift_code' => $this->swift_code,
            'iban' => $this->iban,
        ]);

        // Reset logo upload
        $this->logo = null;

        session()->flash('message', 'Company profile saved successfully');
    }

    public function getIndustries()
    {
        return [
            'technology' => 'Technology',
            'healthcare' => 'Healthcare',
            'finance' => 'Finance',
            'retail' => 'Retail',
            'manufacturing' => 'Manufacturing',
            'education' => 'Education',
            'real_estate' => 'Real Estate',
            'hospitality' => 'Hospitality',
            'construction' => 'Construction',
            'transportation' => 'Transportation',
            'agriculture' => 'Agriculture',
            'consulting' => 'Consulting',
            'media' => 'Media & Entertainment',
            'energy' => 'Energy',
            'other' => 'Other',
        ];
    }

    public function getCompanySizes()
    {
        return [
            'startup' => 'Startup (1-10 employees)',
            'small' => 'Small (11-50 employees)',
            'medium' => 'Medium (51-200 employees)',
            'large' => 'Large (201-1000 employees)',
            'enterprise' => 'Enterprise (1000+ employees)',
        ];
    }

    public function render()
    {
        return view('livewire.settings.company-profile');
    }
}
