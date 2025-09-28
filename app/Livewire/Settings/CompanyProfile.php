<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class CompanyProfile extends Component
{
    public string $company_name = '';
    public ?string $company_email = null;
    public ?string $company_phone = null;
    public ?string $company_address = null;

    public function mount(): void
    {
        $data = Setting::get('company.profile', []);
        $this->company_name = (string)($data['name'] ?? '');
        $this->company_email = $data['email'] ?? null;
        $this->company_phone = $data['phone'] ?? null;
        $this->company_address = $data['address'] ?? null;
    }

    protected function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('company.profile', [
            'name' => $this->company_name,
            'email' => $this->company_email,
            'phone' => $this->company_phone,
            'address' => $this->company_address,
        ]);

        session()->flash('status', 'Company profile saved');
    }

    public function render()
    {
        return view('livewire.settings.company-profile');
    }
}
