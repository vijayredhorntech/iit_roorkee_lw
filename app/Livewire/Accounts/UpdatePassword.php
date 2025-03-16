<?php

namespace App\Livewire\Accounts;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $newPassword = '';
    public $confirmPassword = '';

    protected $rules = [
        'newPassword' => 'required|min:8',
        'confirmPassword' => 'required|same:newPassword'
    ];

    protected $messages = [
        'newPassword.required' => 'New password is required',
        'newPassword.min' => 'Password must be at least 8 characters',
        'confirmPassword.required' => 'Please confirm your password',
        'confirmPassword.same' => 'Passwords do not match'
    ];

    public function openPasswordUpdateModel()
    {
        $this->resetForm();
    }

    public function updatePassword()
    {
        $this->validate();

        $user = auth()->user();
        
        if ($user->last_password_change && now()->diffInHours($user->last_password_change) <= 24) {
            $hoursLeft = floor(24 - now()->diffInHours($user->last_password_change));
            session()->flash('error', "You can only change your password once every 24 hours. Please wait {$hoursLeft} more hours.");
            return;
        }

        $user->update([
            'password' => Hash::make($this->newPassword),
            'last_password_change' => now()
        ]);

        $this->resetForm();
        session()->flash('success', 'Password updated successfully!');
    }

    public function resetForm()
    {
        $this->reset(['newPassword', 'confirmPassword']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.accounts.update-password');
    }
}
