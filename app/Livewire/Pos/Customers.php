<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Customer;

class Customers extends Component
{
    public $search = '';
    public $selectedCustomer = null;

    protected $listeners = [
        'checkout' => 'showCustomerSelect',
    ];

    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::find($customerId);
        session(['pos_customer' => $this->selectedCustomer?->id]);
        $this->dispatch('customerSelected');
    }

    public function showCustomerSelect()
    {
        // Optionally show modal or highlight customer tab
        $this->dispatchBrowserEvent('showCustomerTab');
    }

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->limit(10)
            ->get();
        $selectedCustomer = $this->selectedCustomer;
        return view('livewire.pos.customers', compact('customers', 'selectedCustomer'));
    }
}
