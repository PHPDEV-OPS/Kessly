<?php

namespace App\Livewire\Settings;

use App\Models\User;
use App\Notifications\UserRegistrationNotification;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

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

    public function verifyUser($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->is_verified) {
            $user->update(['is_verified' => true]);

            // Send notification to user
            $user->notify(new UserRegistrationNotification($user));

            session()->flash('message', 'User ' . $user->name . ' has been verified and notified.');
        }
    }

    public function unverifyUser($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->is_verified) {
            $user->update(['is_verified' => false]);
            session()->flash('message', 'User ' . $user->name . ' has been unverified.');
        }
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent deleting admin users
        if ($user->hasRole('Administrator') || $user->hasRole('Super Admin')) {
            session()->flash('error', 'Cannot delete administrator accounts.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User ' . $user->name . ' has been deleted.');
    }

    public function render()
    {
        $users = User::with('role')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== '', function ($query) {
                if ($this->status === 'verified') {
                    $query->where('is_verified', true);
                } elseif ($this->status === 'unverified') {
                    $query->where('is_verified', false);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.settings.user-management', compact('users'));
    }
}