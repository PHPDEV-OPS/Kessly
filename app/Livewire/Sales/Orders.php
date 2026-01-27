<?php

namespace App\Livewire\Sales;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    // Listing controls
    public string $search = '';
    public string $statusFilter = '';
    public string $sortField = 'order_date';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    // Form fields
    public ?int $orderId = null;
    public string $order_number = '';
    public ?int $customer_id = null;
    public ?string $order_date = null; // Y-m-d
    public float $total_amount = 0.0;

    // UI state
    public bool $showForm = false;
    public bool $showView = false;
    public ?Order $viewingOrder = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'order_date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected function rules(): array
    {
        return [
            'order_number' => [
                'required', 'string', 'max:255',
                Rule::unique('orders', 'order_number')->ignore($this->orderId),
            ],
            'customer_id' => ['required', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
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
        $this->order_number = $this->generateOrderNumber();
        $this->order_date = now()->toDateString();
        $this->showForm = true;
    }

    public function view(int $id): void
    {
        $this->viewingOrder = Order::with('customer')->findOrFail($id);
        $this->showView = true;
    }

    public function closeView(): void
    {
        $this->showView = false;
        $this->viewingOrder = null;
    }

    public function print(int $id): void
    {
        $this->dispatch('print-order', orderId: $id);
    }

    public function edit(int $id): void
    {
        $o = Order::findOrFail($id);
        $this->orderId = $o->id;
        $this->order_number = $o->order_number;
        $this->customer_id = $o->customer_id;
        $this->order_date = optional($o->order_date)->toDateString();
        $this->total_amount = (float)$o->total_amount;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'order_number' => $this->order_number,
            'customer_id' => $this->customer_id,
            'order_date' => $this->order_date,
            'total_amount' => $this->total_amount,
        ];

        if ($this->orderId) {
            Order::whereKey($this->orderId)->update($data);
            session()->flash('status', 'Order updated');
        } else {
            Order::create($data);
            session()->flash('status', 'Order created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Order::whereKey($id)->delete();
        session()->flash('status', 'Order deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function export()
    {
        $query = Order::forUser()
            ->with('customer')
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            });

        $allowed = ['order_number', 'order_date', 'total_amount', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'order_date';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $orders = $query->orderBy($field, $direction)->get();

        $csv = "Order Number,Customer,Order Date,Total Amount\n";
        foreach ($orders as $order) {
            $csv .= '"' . str_replace('"', '""', $order->order_number) . '",';
            $csv .= '"' . str_replace('"', '""', $order->customer?->name ?? '') . '",';
            $csv .= '"' . ($order->order_date ? $order->order_date->format('Y-m-d') : '') . '",';
            $csv .= '"' . number_format($order->total_amount, 2) . '"';
            $csv .= "\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'orders-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function resetForm(): void
    {
        $this->reset(['orderId', 'order_number', 'customer_id', 'order_date', 'total_amount']);
        $this->total_amount = 0.0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    protected function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . now()->format('Ymd');
        $latest = Order::where('order_number', 'like', $prefix . '%')
            ->latest('id')
            ->value('order_number');

        $seq = 1;
        if ($latest && str_contains($latest, '-')) {
            $parts = explode('-', $latest);
            $last = $parts[count($parts) - 1];
            if (ctype_digit($last)) {
                $seq = (int)$last + 1;
            }
        }

        return $prefix . '-' . str_pad((string)$seq, 4, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        $query = Order::forUser()
            ->with('customer')
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            });

        $allowed = ['order_number', 'order_date', 'total_amount', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'order_date';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $orders = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.sales.orders', [
            'orders' => $orders,
            'customers' => Customer::forUser()->orderBy('name')->get(),
        ]);
    }
}
