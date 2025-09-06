<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.admin')]
class ManageUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Title('Manage Users')]

    // Search and filter
    public $search = '';
    public $roleFilter = 'all';

    // Form properties
    public $userId;
    public $firstname = '';
    public $surname = '';
    public $email = '';
    public $password = '';
    public $role = '';

    // UI state
    public $showModal = false;
    public $editMode = false;

    protected function rules()
    {
        return [
            'firstname' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->userId ?? ''),
            'role' => 'required|in:' . implode(',', array_keys($this->roles)),
            'password' => $this->editMode
                ? ['nullable', Password::defaults()]
                : ['required', Password::defaults()],
        ];
    }

    protected $messages = [
        'firstname.required' => 'First name is required.',
        'surname.required' => 'Surname is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'role.required' => 'Please select a role.',
        'role.in' => 'Invalid role selected.',
        'password.required' => 'Password is required for new users.',
    ];

    public function getRolesProperty()
    {
        return [
            User::ROLE_ADMINISTRATOR => 'Administrator',
            User::ROLE_EDITOR => 'Editor',
            User::ROLE_MODERATOR => 'Moderator',
        ];
    }

    public function mount()
    {
        $this->role = User::ROLE_MODERATOR; // Default role for new users
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['userId', 'firstname', 'surname', 'email', 'password', 'role']);
        $this->role = User::ROLE_MODERATOR;
        $this->editMode = false;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function edit(User $user)
    {
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $this->dispatch('error', 'Cannot edit super admin users.');
            return;
        }

        $this->userId = $user->id;
        $this->firstname = $user->firstname;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->editMode = true;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $user = User::findOrFail($this->userId);
                $user->update([
                    'firstname' => $this->firstname,
                    'surname' => $this->surname,
                    'email' => $this->email,
                    'role' => $this->role,
                ] + ($this->password ? ['password' => Hash::make($this->password)] : []));

                $this->dispatch('success', 'User updated successfully.');
            } else {
                User::create([
                    'firstname' => $this->firstname,
                    'surname' => $this->surname,
                    'email' => $this->email,
                    'role' => $this->role,
                    'password' => Hash::make($this->password),
                ]);

                $this->dispatch('success', 'User created successfully.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('error', 'There was an error saving the user.');
        }
    }

    public function confirmDelete(User $user)
    {
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $this->dispatch('error', 'Cannot delete super admin users.');
            return;
        }

        // Will show a confirmation dialog
        $this->dispatch('confirm-user-deletion', [
            'user_id' => $user->id,
            'name' => $user->firstname . ' ' . $user->surname
        ]);
    }

    public function delete(User $user)
    {
        if ($user->role !== User::ROLE_SUPER_ADMIN) {
            $user->delete();
            $this->dispatch('success', 'User deleted successfully.');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['userId', 'firstname', 'surname', 'email', 'password', 'role']);
        $this->resetValidation();
    }

    public function render()
    {
        $query = User::query()
            ->whereNotIn('role', [User::ROLE_SUPER_ADMIN])
            ->where('id', '!=', auth()->id())
            ->when($this->search, function($q) {
                $term = '%' . $this->search . '%';
                $q->where(function($query) use ($term) {
                    $query->where('firstname', 'like', $term)
                          ->orWhere('surname', 'like', $term)
                          ->orWhere('email', 'like', $term);
                });
            })
            ->when($this->roleFilter !== 'all', function($q) {
                $q->where('role', $this->roleFilter);
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.admin.manage-users', [
            'users' => $query->paginate(10),
        ]);
    }
}
