<?php

namespace App\Livewire\Hr;

use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class AttendanceManagement extends Component
{
    use WithPagination;

    public $selectedDate;
    public $search = '';
    public $employee_id = '';
    public $sortField = 'date';
    public $sortDirection = 'desc';

    // Modal state
    public $showModal = false;
    public $editing = false;
    public $attendanceId = null;

    // Form fields
    public $date = '';
    public $clock_in = '';
    public $clock_out = '';
    public $break_start = '';
    public $break_end = '';
    public $status = 'present';
    public $notes = '';

    public function getRules()
    {
        $rules = [
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_start' => 'nullable|date_format:H:i|after:clock_in',
            'break_end' => 'nullable|date_format:H:i|after:break_start|before:clock_out',
            'status' => 'required|in:present,absent,late,half_day',
            'notes' => 'nullable|string',
        ];

        // Add unique validation for employee and date combination
        if ($this->editing) {
            $rules['employee_id'] .= '|unique:attendances,employee_id,' . $this->attendanceId . ',id,date,' . $this->date;
        } else {
            $rules['employee_id'] .= '|unique:attendances,employee_id,NULL,id,date,' . $this->date;
        }

        return $rules;
    }

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->date = $this->selectedDate;
    }

    public function updatedSelectedDate()
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

    public function edit($attendanceId)
    {
        $this->attendanceId = $attendanceId;
        $attendance = Attendance::findOrFail($attendanceId);
        
        $this->employee_id = $attendance->employee_id;
        $this->date = $attendance->date->format('Y-m-d');
        $this->clock_in = $attendance->clock_in?->format('H:i');
        $this->clock_out = $attendance->clock_out?->format('H:i');
        $this->break_start = $attendance->break_start?->format('H:i');
        $this->break_end = $attendance->break_end?->format('H:i');
        $this->status = $attendance->status;
        $this->notes = $attendance->notes;
        
        $this->showModal = true;
        $this->editing = true;
    }

    public function save()
    {
        $this->validate($this->getRules());

        $clockIn = $this->clock_in ? Carbon::createFromFormat('Y-m-d H:i', $this->date . ' ' . $this->clock_in) : null;
        $clockOut = $this->clock_out ? Carbon::createFromFormat('Y-m-d H:i', $this->date . ' ' . $this->clock_out) : null;
        $breakStart = $this->break_start ? Carbon::createFromFormat('Y-m-d H:i', $this->date . ' ' . $this->break_start) : null;
        $breakEnd = $this->break_end ? Carbon::createFromFormat('Y-m-d H:i', $this->date . ' ' . $this->break_end) : null;

        $hoursWorked = 0;
        if ($clockIn && $clockOut) {
            $totalMinutes = $clockIn->diffInMinutes($clockOut);
            if ($breakStart && $breakEnd) {
                $breakMinutes = $breakStart->diffInMinutes($breakEnd);
                $totalMinutes -= $breakMinutes;
            }
            $hoursWorked = round($totalMinutes / 60, 2);
        }

        $data = [
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'clock_in' => $clockIn,
            'clock_out' => $clockOut,
            'break_start' => $breakStart,
            'break_end' => $breakEnd,
            'hours_worked' => $hoursWorked,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->editing) {
            Attendance::findOrFail($this->attendanceId)->update($data);
            session()->flash('message', 'Attendance updated successfully.');
        } else {
            Attendance::create($data);
            session()->flash('message', 'Attendance recorded successfully.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($attendanceId)
    {
        Attendance::findOrFail($attendanceId)->delete();
        session()->flash('message', 'Attendance record deleted successfully.');
    }

    public function resetForm()
    {
        $this->attendanceId = null;
        $this->employee_id = '';
        $this->date = $this->selectedDate;
        $this->clock_in = '';
        $this->clock_out = '';
        $this->break_start = '';
        $this->break_end = '';
        $this->status = 'present';
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
        $attendances = Attendance::with(['employee.user'])
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('date', $this->selectedDate);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('employee.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $employees = Employee::with('user')->active()->get();

        // Statistics
        $totalEmployees = Employee::active()->count();
        $presentToday = Attendance::whereDate('date', $this->selectedDate)
                                 ->where('status', 'present')
                                 ->count();
        $absentToday = Attendance::whereDate('date', $this->selectedDate)
                                ->where('status', 'absent')
                                ->count();
        $lateToday = Attendance::whereDate('date', $this->selectedDate)
                              ->where('status', 'late')
                              ->count();

        return view('livewire.hr.attendance-management', compact(
            'attendances', 
            'employees', 
            'totalEmployees', 
            'presentToday', 
            'absentToday', 
            'lateToday'
        ));
    }
}