<?php

namespace App\Livewire\Settings;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public ?int $role_id = null;
    public ?string $password = null;
    public bool $is_verified = false;

    public bool $showForm = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected function rules(): array
    {
        $passwordRule = $this->userId ? ['nullable', 'string', 'min:8'] : ['required', 'string', 'min:8'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'role_id' => ['nullable', 'exists:roles,id'],
            'password' => $passwordRule,
            'is_verified' => ['boolean'],
        ];
    }

    public function updatedSearch(): void
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

    public function edit(int $id): void
    {
        $u = User::findOrFail($id);
        $this->userId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->role_id = $u->role_id;
        $this->is_verified = $u->is_verified;
        $this->password = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'is_verified' => $this->is_verified,
        ];

        if ($this->password) {
            $data['password'] = $this->password; // will be hashed by model cast
        }

        if ($this->userId) {
            $user = User::find($this->userId);
            $wasVerified = $user->is_verified;
            User::whereKey($this->userId)->update($data);
            $user->refresh();
            if (!$wasVerified && $this->is_verified) {
                $user->notify(new \App\Notifications\AccountVerified());
            }
            session()->flash('status', 'User updated');
        } else {
            $user = User::create($data);
            if ($this->is_verified) {
                $user->notify(new \App\Notifications\AccountVerified());
            }
            // Note: Admin-created users are typically pre-verified, so no admin notification needed
            session()->flash('status', 'User created');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        if (auth()->id() === $id) {
            session()->flash('status', 'You cannot delete the currently authenticated user.');
            return;
        }
        User::whereKey($id)->delete();
        session()->flash('status', 'User deleted');
        $this->resetPage();
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset(['userId', 'name', 'email', 'role_id', 'password', 'is_verified']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $query = User::query()
            ->with('role')
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            });

        $allowed = ['name', 'email', 'created_at'];
        $field = in_array($this->sortField, $allowed, true) ? $this->sortField : 'name';
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        $users = $query->orderBy($field, $direction)->paginate($this->perPage);

        return view('livewire.settings.users', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }
}
