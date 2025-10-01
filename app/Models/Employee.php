<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'user_id',
        'branch_id',
        'department',
        'position',
        'hire_date',
        'salary',
        'employment_status',
        'manager_id',
        'phone',
        'address',
        'emergency_contact',
        'emergency_phone',
        'notes',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->name : 'N/A';
    }

    public function scopeManagers($query)
    {
        return $query->whereIn('position', ['Manager', 'Senior Manager', 'Department Head']);
    }

    public function scopeStaff($query)
    {
        return $query->whereNotIn('position', ['Manager', 'Senior Manager', 'Department Head']);
    }

    public function scopeActive($query)
    {
        return $query->where('employment_status', 'active');
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}