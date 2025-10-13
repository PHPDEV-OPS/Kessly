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
    public $background_image;
    public ?string $company_background_image = null;
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
        $this->company_name = (string)($data['name'] ?? 'Kessly Wine Distribution');
        $this->company_email = $data['email'] ?? 'info@kessly.com';
        $this->company_phone = $data['phone'] ?? '+254 700 000 000';
        $this->company_website = $data['website'] ?? 'https://kessly.com';
        $this->company_address = $data['address'] ?? null;
        $this->company_city = $data['city'] ?? null;
        $this->company_state = $data['state'] ?? null;
        $this->company_postal_code = $data['postal_code'] ?? null;
        $this->company_country = $data['country'] ?? 'Kenya';
        $this->tax_number = $data['tax_number'] ?? null;
        $this->registration_number = $data['registration_number'] ?? null;
        $this->vat_number = $data['vat_number'] ?? null;
        $this->industry = $data['industry'] ?? 'wine_distribution';
        $this->company_size = $data['company_size'] ?? null;
        $this->founded_year = $data['founded_year'] ?? null;
        $this->company_logo = $data['logo'] ?? null;
        $this->company_background_image = $data['background_image'] ?? null;
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
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'company_description' => ['nullable', 'string', 'max:1000'],
            'company_slogan' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:255'],
            'swift_code' => ['nullable', 'string', 'max:20'],
            'iban' => ['nullable', 'string', 'max:34'],
        ];
    }

    public function clearLogoUpload()
    {
        $this->logo = null;
        $this->resetErrorBag('logo');
    }

    public function clearBackgroundImageUpload()
    {
        $this->background_image = null;
        $this->resetErrorBag('background_image');
    }

    public function removeLogo()
    {
        try {
            // Delete current logo file if it exists
            if ($this->company_logo && file_exists(storage_path('app/public/' . $this->company_logo))) {
                unlink(storage_path('app/public/' . $this->company_logo));
            }
            
            // Reset logo properties
            $this->logo = null;
            $this->company_logo = null;
            
            // Update settings
            $data = Setting::get('company.profile', []);
            $data['logo'] = null;
            Setting::set('company.profile', $data);
            
            session()->flash('message', 'Logo removed successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error removing logo: ' . $e->getMessage());
        }
    }

    public function removeBackgroundImage()
    {
        try {
            // Delete current background image file if it exists
            if ($this->company_background_image && file_exists(storage_path('app/public/' . $this->company_background_image))) {
                unlink(storage_path('app/public/' . $this->company_background_image));
            }
            
            // Reset background image properties
            $this->background_image = null;
            $this->company_background_image = null;
            
            // Update settings
            $data = Setting::get('company.profile', []);
            $data['background_image'] = null;
            Setting::set('company.profile', $data);
            
            session()->flash('message', 'Background image removed successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error removing background image: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        $logoPath = $this->company_logo;
        $backgroundImagePath = $this->company_background_image;
        
        // Handle logo upload
        if ($this->logo) {
            try {
                // Delete old logo if it exists
                if ($this->company_logo && file_exists(storage_path('app/public/' . $this->company_logo))) {
                    unlink(storage_path('app/public/' . $this->company_logo));
                }
                
                // Store the new logo
                $logoPath = $this->logo->store('company-logos', 'public');
                
                if (!$logoPath) {
                    session()->flash('error', 'Failed to upload logo. Please try again.');
                    return;
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Error uploading logo: ' . $e->getMessage());
                return;
            }
        }

        // Handle background image upload
        if ($this->background_image) {
            try {
                // Delete old background image if it exists
                if ($this->company_background_image && file_exists(storage_path('app/public/' . $this->company_background_image))) {
                    unlink(storage_path('app/public/' . $this->company_background_image));
                }
                
                // Store the new background image
                $backgroundImagePath = $this->background_image->store('company-backgrounds', 'public');
                
                if (!$backgroundImagePath) {
                    session()->flash('error', 'Failed to upload background image. Please try again.');
                    return;
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Error uploading background image: ' . $e->getMessage());
                return;
            }
        }

        try {
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
                'background_image' => $backgroundImagePath,
                'description' => $this->company_description,
                'slogan' => $this->company_slogan,
                'bank_name' => $this->bank_name,
                'bank_account' => $this->bank_account,
                'swift_code' => $this->swift_code,
                'iban' => $this->iban,
            ]);

            // Update the component properties with new paths
            $this->company_logo = $logoPath;
            $this->company_background_image = $backgroundImagePath;
            
            // Reset upload fields
            $this->logo = null;
            $this->background_image = null;

            $message = 'Company profile saved successfully';
            if ($logoPath !== $this->company_logo) {
                $message .= ' Logo updated and will be visible immediately.';
            }
            
            session()->flash('message', $message);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving company profile: ' . $e->getMessage());
        }
    }    public function getIndustries()
    {
        return [
            'wine_distribution' => 'Wine Distribution & Sales',
        ];
    }

    public function getCompanySizes()
    {
        return [
            'small' => 'Small Business (1-20 employees)',
            'medium' => 'Medium Business (21-100 employees)',
        ];
    }

    protected function messages(): array
    {
        return [
            'logo.image' => 'The logo must be an image file.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, webp.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'company_name.required' => 'Company name is required.',
            'company_email.email' => 'Please enter a valid email address.',
            'company_website.url' => 'Please enter a valid website URL.',
        ];
    }

    public function render()
    {
        return view('livewire.settings.company-profile');
    }
}
