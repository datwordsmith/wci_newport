<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.admin')]
class MyProfile extends Component
{
    #[Title('My Profile')]

    // Profile properties
    public $firstname = '';
    public $surname = '';
    public $email = '';

    // Password change properties
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // UI state
    public $showPasswordSection = false;

    protected function rules()
    {
        return [
            'firstname' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
            'new_password_confirmation' => 'nullable',
        ];
    }

    protected $messages = [
        'firstname.required' => 'First name is required.',
        'surname.required' => 'Surname is required.',
        'current_password.required_with' => 'Please enter your current password to change password.',
        'current_password.current_password' => 'Current password is incorrect.',
        'new_password.confirmed' => 'Password confirmation does not match.',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->firstname = $user->firstname;
        $this->surname = $user->surname;
        $this->email = $user->email;
    }

    public function togglePasswordSection()
    {
        $this->showPasswordSection = !$this->showPasswordSection;

        if (!$this->showPasswordSection) {
            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            $this->resetErrorBag(['current_password', 'new_password', 'new_password_confirmation']);
        }
    }

    public function updateProfile()
    {
        // Validate profile fields only
        $this->validate([
            'firstname' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
        ]);

        try {
            auth()->user()->update([
                'firstname' => $this->firstname,
                'surname' => $this->surname,
            ]);

            session()->flash('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'There was an error updating your profile.');
        }
    }

    public function changePassword()
    {
        // Validate password fields only
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => ['required', 'confirmed', Password::defaults()],
            'new_password_confirmation' => 'required',
        ]);

        try {
            auth()->user()->update([
                'password' => Hash::make($this->new_password)
            ]);

            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            $this->showPasswordSection = false;
            $this->resetErrorBag(['current_password', 'new_password', 'new_password_confirmation']);

            session()->flash('success', 'Password changed successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'There was an error changing your password.');
        }
    }

    public function render()
    {
        return view('livewire.admin.my-profile');
    }
}
