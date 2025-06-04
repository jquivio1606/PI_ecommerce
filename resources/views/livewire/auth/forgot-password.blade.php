<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('Se enviará un enlace de restablecimiento si la cuenta existe.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    @section('title', 'Olvidaste tu Contraseña?')    
<x-auth-header
        :title="__('¿Olvidaste tu contraseña?')"
        :description="__('Introduce tu correo para recibir un enlace de restablecimiento de contraseña')"
        title="¿Olvidaste tu contraseña?"
        aria-label="Formulario para recuperar contraseña"
    />

    <!-- Estado de sesión -->
    <x-auth-session-status
        class="text-center"
        :status="session('status')"
        role="alert"
        aria-live="polite"
    />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6" aria-label="Formulario para enviar enlace de restablecimiento">
        <!-- Correo electrónico -->
        <flux:input
            wire:model="email"
            :label="__('Correo electrónico')"
            type="email"
            required
            autofocus
            placeholder="correo@ejemplo.com"
            title="Introduce tu correo electrónico"
            aria-label="Correo electrónico"
        />

        <flux:button variant="primary" type="submit" class="w-full">
            {{ __('Enviar enlace de restablecimiento') }}
        </flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400" aria-label="Enlace para volver a iniciar sesión">
        {{ __('O, vuelve a') }}
        <flux:link
            :href="route('login')"
            wire:navigate
            title="Iniciar sesión"
            aria-label="Enlace para iniciar sesión"
        >
            {{ __('iniciar sesión') }}
        </flux:link>
    </div>
</div>
