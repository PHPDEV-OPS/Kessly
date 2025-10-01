<?php

namespace App\Livewire\Finance;

use App\Models\Payroll;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class PayrollManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $pay_period_start = '';
    public $pay_period_end = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Modal state
    public $showModal = false;
    public $editing = false;
    public $payrollId = null;

    // Form fields
    public $employee_id = '';
    public $period_start = '';
    public $period_end = '';
    public $basic_salary = '';
    public $overtime_hours = '';
    public $overtime_rate = '';
    public $bonus = '';
    public $deductions = '';
    public $tax_deduction = '';
    public $payroll_status = 'pending';
    public $notes = '';

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'period_start' => 'required|date',
        'period_end' => 'required|date|after_or_equal:period_start',
        'basic_salary' => 'required|numeric|min:0',
        'overtime_hours' => 'nullable|numeric|min:0',
        'overtime_rate' => 'nullable|numeric|min:0',
        'bonus' => 'nullable|numeric|min:0',
        'deductions' => 'nullable|numeric|min:0',
        'tax_deduction' => 'nullable|numeric|min:0',
        'payroll_status' => 'required|in:pending,processed,cancelled',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        $this->pay_period_start = now()->startOfMonth()->format('Y-m-d');
        $this->pay_period_end = now()->endOfMonth()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editing = false;
    }

    public function edit($payrollId)
    {
        $this->payrollId = $payrollId;
        $payroll = Payroll::findOrFail($payrollId);
        
        $this->employee_id = $payroll->employee_id;
        $this->period_start = $payroll->pay_period_start->format('Y-m-d');
        $this->period_end = $payroll->pay_period_end->format('Y-m-d');
        $this->basic_salary = $payroll->basic_salary;
        $this->overtime_hours = $payroll->overtime_hours;
        $this->overtime_rate = $payroll->overtime_rate;
        $this->bonus = $payroll->bonus;
        $this->deductions = $payroll->deductions;
        $this->tax_deduction = $payroll->tax_deduction;
        $this->payroll_status = $payroll->status;
        $this->notes = $payroll->notes;
        
        $this->showModal = true;
        $this->editing = true;
    }

    public function save()
    {
        $rules = $this->rules;
        
        // Prevent duplicate payroll records for the same employee and period
        if ($this->editing) {
            $rules['employee_id'] .= '|unique:payrolls,employee_id,' . $this->payrollId . ',id,pay_period_start,' . $this->period_start . ',pay_period_end,' . $this->period_end;
        } else {
            $rules['employee_id'] .= '|unique:payrolls,employee_id,NULL,id,pay_period_start,' . $this->period_start . ',pay_period_end,' . $this->period_end;
        }
        
        $this->validate($rules);

        $overtimePay = ($this->overtime_hours ?? 0) * ($this->overtime_rate ?? 0);
        $grossPay = $this->basic_salary + $overtimePay + ($this->bonus ?? 0);
        $netPay = $grossPay - ($this->deductions ?? 0) - ($this->tax_deduction ?? 0);

        $data = [
            'employee_id' => $this->employee_id,
            'pay_period_start' => $this->period_start,
            'pay_period_end' => $this->period_end,
            'basic_salary' => $this->basic_salary,
            'overtime_hours' => $this->overtime_hours ?? 0,
            'overtime_rate' => $this->overtime_rate ?? 0,
            'overtime_pay' => $overtimePay,
            'bonus' => $this->bonus ?? 0,
            'deductions' => $this->deductions ?? 0,
            'tax_deduction' => $this->tax_deduction ?? 0,
            'gross_pay' => $grossPay,
            'net_pay' => $netPay,
            'status' => $this->payroll_status,
            'notes' => $this->notes,
        ];

        if ($this->payroll_status === 'processed') {
            $data['processed_at'] = now();
            $data['processed_by'] = auth()->id();
        }

        if ($this->editing) {
            Payroll::findOrFail($this->payrollId)->update($data);
            session()->flash('message', 'Payroll updated successfully.');
        } else {
            Payroll::create($data);
            session()->flash('message', 'Payroll created successfully.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function processPayroll($payrollId)
    {
        $payroll = Payroll::findOrFail($payrollId);
        $payroll->update([
            'status' => 'processed',
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);

        session()->flash('message', 'Payroll processed successfully.');
    }

    public function delete($payrollId)
    {
        Payroll::findOrFail($payrollId)->delete();
        session()->flash('message', 'Payroll deleted successfully.');
    }

    private function resetForm()
    {
        $this->payrollId = null;
        $this->employee_id = '';
        $this->period_start = '';
        $this->period_end = '';
        $this->basic_salary = '';
        $this->overtime_hours = '';
        $this->overtime_rate = '';
        $this->bonus = '';
        $this->deductions = '';
        $this->tax_deduction = '';
        $this->payroll_status = 'pending';
        $this->notes = '';
        $this->editing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $payrolls = Payroll::with(['employee.user', 'processor'])
            ->when($this->search, function ($query) {
                $query->whereHas('employee.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->pay_period_start && $this->pay_period_end, function ($query) {
                $query->whereBetween('pay_period_start', [$this->pay_period_start, $this->pay_period_end]);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $employees = Employee::with('user')->active()->get();

        // Statistics
        $totalPayrolls = Payroll::count();
        $processedPayrolls = Payroll::where('status', 'processed')->count();
        $pendingPayrolls = Payroll::where('status', 'pending')->count();
        $totalPayroll = Payroll::where('status', 'processed')->sum('net_pay');

        return view('livewire.finance.payroll-management', compact(
            'payrolls', 
            'employees', 
            'totalPayrolls', 
            'processedPayrolls', 
            'pendingPayrolls', 
            'totalPayroll'
        ));
    }
}