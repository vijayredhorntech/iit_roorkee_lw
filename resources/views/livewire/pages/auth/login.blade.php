<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input    wire:model="form.email"  id="email" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 text-primary rounded-[4px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000" name="remember">
                    <span class="text-center text-primary text-sm font-medium ml-2">{{ __('Remember me') }}</span>
                </label>
            @endif
        </div>

        <div class="">
            <x-primary-button wire:loading.attr="disabled">
                <span wire:loading.remove>Sign In</span>
                <span wire:loading>
                    Signing in... Please wait
                </span>
            </x-primary-button>
        </div>
        <div class="flex justify-center mt-4">
            <p class="text-center text-primary text-sm font-medium">
                Forgot password? <a href="{{route('password.request')}}" class="text-secondary hover:text-danger transition ease-in duration-2000 font-semibold">
                    Regain Access ✌️
                </a>
        </div>


    </form>
</div>
