<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Notifications\NewUserCredentials;
use App\Notifications\ProfileUpdatedByAdmin;
use Illuminate\Support\Str;

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
    public $isLoading = false;

    protected function rules()
    {
        return [
            'firstname' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            // Email only validated for new users, not editable for existing users
            'email' => $this->editMode ? '' : 'required|email|unique:users,email',
            'role' => 'required|in:' . implode(',', array_keys($this->roles)),
            // Password only required when editing and user wants to change it
            'password' => $this->editMode
                ? ['nullable', Password::defaults()]
                : [], // No password validation for new users - we generate it
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

    /**
     * Generate a strong 8-character password
     */
    private function generateStrongPassword(): string
    {
        // Mix of uppercase, lowercase, numbers, and symbols
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%&*';

        // Ensure at least one character from each set
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Fill the remaining 4 characters
        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < 8; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password
        return str_shuffle($password);
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
        $this->isLoading = true;

        try {
            $this->validate();

            if ($this->editMode) {
                $user = User::findOrFail($this->userId);

                // Track what fields are being changed
                $updatedFields = [];
                $originalData = $user->only(['firstname', 'surname', 'role']);

                // Check for changes in names and role
                if ($user->firstname !== $this->firstname) {
                    $updatedFields['firstname'] = $this->firstname;
                }
                if ($user->surname !== $this->surname) {
                    $updatedFields['surname'] = $this->surname;
                }
                if ($user->role !== $this->role) {
                    $updatedFields['role'] = $this->role;
                }

                // Check if password is being changed
                $newPassword = null;
                $updateData = [
                    'firstname' => $this->firstname,
                    'surname' => $this->surname,
                    'role' => $this->role,
                ];

                if ($this->password) {
                    $newPassword = $this->password; // Store plain password for email
                    $updateData['password'] = Hash::make($this->password);
                }

                // Only update firstname, surname, and role for existing users
                $user->update($updateData);

                // Send notification if anything was changed
                if (!empty($updatedFields) || $newPassword) {
                    $user->notify(new ProfileUpdatedByAdmin($updatedFields, $newPassword));
                }

                $this->dispatch('success', 'User updated successfully. ' .
                    ((!empty($updatedFields) || $newPassword) ? 'Notification email sent to user.' : ''));
            } else {
                // Generate strong password for new user
                $generatedPassword = $this->generateStrongPassword();

                $user = User::create([
                    'firstname' => $this->firstname,
                    'surname' => $this->surname,
                    'email' => $this->email,
                    'role' => $this->role,
                    'password' => Hash::make($generatedPassword),
                ]);

                // Send email with credentials
                $user->notify(new NewUserCredentials($generatedPassword, $this->role));

                $this->dispatch('success', 'User created successfully. Login credentials have been sent to their email.');
            }

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->isLoading = false;
            throw $e; // Re-throw validation exception so Livewire handles it
        } catch (\Exception $e) {
            $this->dispatch('error', 'There was an error saving the user: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
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
        $this->isLoading = false;
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
