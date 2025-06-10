<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public $codigo;

    public function mount()
    {
        // Validar sesión 2FA
        if (!session()->has('2fa:user:code') || !session()->has('2fa:user:id')) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            $this->redirect(route('login'));
        }
    }

    public function verification()
    {
        $this->validate(
            [
                'codigo' => 'required|digits:6',
            ],
            [
                'codigo.required' => 'Por favor, introduce el código de verificación.',
                'codigo.digits' => 'El código debe tener exactamente 6 dígitos.',
            ],
        );

        $codigoGuardado = session('2fa:user:code');

        if ($this->codigo !== $codigoGuardado) {
            // Código introducido no coincide con el guardado:
            $this->addError('codigo', 'El código introducido es incorrecto.');
        } else {
            // Código correcto:
            session()->forget(['2fa:user:id', '2fa:user:code']); // Limpia datos temporales 2FA
            session(['2fa:verified' => true]); // Marcar 2FA como completado

            // Redirige al destino (dashboard o ruta que quieras)
            return redirect()->intended(route('dashboard'));
        }
    }
};
?>
<div class="flex flex-col gap-6">
    @section('title', 'Segunda Verificación')
    <x-auth-header title="Verificación en 2 pasos"
        description="Le hemos enviado un email. Por favor introduzca el código que contiene el mensaje para continuar"
        aria-label="Formulario para iniciar sesión en tu cuenta" />

    <x-auth-session-status class="text-center" :status="session('status')" role="alert" aria-live="polite" />

    <form wire:submit.prevent="verification" class="flex flex-col gap-6" aria-label="Formulario de Verificación">
        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
            <input type="text" id="codigo" name="codigo" wire:model="codigo" required autofocus
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                placeholder="Introduce el código: XXXXXX" title="Introduce el código de verificación"
                aria-label="Código de verificación" />
            <span style="font-size: smaller; font-weight: lighter;"> Campo obligatorio</span>

            @error('codigo')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full btn btn-outline-dark py-2 px-4 rounded hover:bg-blue-700">
                {{ __('Enviar Código') }}
            </button>
        </div>
    </form>
</div>
