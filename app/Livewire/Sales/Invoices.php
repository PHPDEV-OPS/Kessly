<?php

namespace App\Livewire\Sales;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Invoices extends Component
{
    use WithPagination;

    // Listing controls
    public string $search = '';
    public string $statusFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    // Form fields
    public ?int $invoiceId = null;
    public string $name = '';
    public ?int $customer_id = null;
    public float $amount = 0.0;

    // UI state
    public bool $showForm = false;
    public bool $showView = false;
    public ?Invoice $viewingInvoice = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id'],
            'amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function view(int $id): void
    {
        $this->viewingInvoice = Invoice::with('customer')->findOrFail($id);
        $this->showView = true;
    }

    public function closeView(): void
    {
        $this->showView = false;
        $this->viewingInvoice = null;
    }

    public function print(int $id): void
    {
        $this->dispatch('print-invoice', invoiceId: $id);
    }

    public function edit(int $id): void
    {
        $inv = Invoice::findOrFail($id);
        $this->invoiceId = $inv->id;
        $this->name = $inv->name;
        $this->customer_id = $inv->customer_id;
        $this->amount = (float)$inv->amount;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'customer_id' => $this->customer_id,
            'amount' => $this->amount,
        ];

        if ($this->invoiceId) {
            Invoice::whereKey($this->invoiceId)->update($data);
            session()->flash('status', 'Invoice updated');
        } else {
            Invoice::create($data);
            session()->flash('status', 'Invoice created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Invoice::whereKey($id)->delete();
        session()->flash('status', 'Invoice deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function export()
    {
        $query = Invoice::query()
            ->with('customer')
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            });

        $allowed = ['name', 'amount', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $invoices = $query->orderBy($field, $direction)->get();

        $csv = "Invoice Name,Customer,Date,Amount\n";
        foreach ($invoices as $invoice) {
            $csv .= '"' . str_replace('"', '""', $invoice->name) . '",';
            $csv .= '"' . str_replace('"', '""', $invoice->customer?->name ?? '') . '",';
            $csv .= '"' . ($invoice->created_at ? $invoice->created_at->format('Y-m-d') : '') . '",';
            $csv .= '"' . number_format($invoice->amount, 2) . '"';
            $csv .= "\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'invoices-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function resetForm(): void
    {
        $this->reset(['invoiceId', 'name', 'customer_id', 'amount']);
        $this->amount = 0.0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Invoice::query()
            ->with('customer')
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            });

        $allowed = ['name', 'amount', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $invoices = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.sales.invoices', [
            'invoices' => $invoices,
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }
}
