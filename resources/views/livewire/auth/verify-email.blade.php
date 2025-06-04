<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="mt-4 flex flex-col gap-6">
    @section('title', 'Verificar email')

    <flux:text class="text-center" role="alert" aria-live="polite">
        {{ __('Por favor, verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar.') }}
    </flux:text>

    @if (session('status') == 'verification-link-sent')
        <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600" role="alert" aria-live="polite">
            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.') }}
        </flux:text>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <flux:button wire:click="sendVerification" variant="primary" class="w-full"
            title="Reenviar correo de verificación" aria-label="Botón para reenviar correo de verificación">
            {{ __('Reenviar correo de verificación') }}
        </flux:button>

        <flux:link class="text-sm cursor-pointer" wire:click="logout" title="Cerrar sesión" aria-label="Cerrar sesión">
            {{ __('Cerrar sesión') }}
        </flux:link>
    </div>
</div>
