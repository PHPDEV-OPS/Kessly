<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'basic_salary',
        'overtime_hours',
        'overtime_rate',
        'overtime_pay',
        'bonus',
        'deductions',
        'tax_deduction',
        'net_pay',
        'gross_pay',
        'status',
        'processed_at',
        'processed_by',
        'notes',
    ];

    protected $casts = [
        'pay_period_start' => 'date',
        'pay_period_end' => 'date',
        'basic_salary' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deductions' => 'decimal:2',
        'tax_deduction' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function calculateGrossPay()
    {
        return $this->basic_salary + $this->overtime_pay + $this->bonus;
    }

    public function calculateNetPay()
    {
        return $this->calculateGrossPay() - $this->deductions - $this->tax_deduction;
    }

    public function scopeForPeriod($query, $start, $end)
    {
        return $query->whereBetween('pay_period_start', [$start, $end]);
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}