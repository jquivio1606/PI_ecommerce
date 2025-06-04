<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public $codigo;

    public function mount()
    {
        if (!session()->has('2fa:user:code')) {
            redirect()->route('login')->send();
        }
    }

    public function verification()
    {
        // Validar que el código esté presente y sea numérico (puedes ajustar según necesidad)
        $this->validate([
            'codigo' => 'required|digits:6',
        ]);

        // Obtener el código guardado en sesión
        $codigoGuardado = session('2fa:user:code');

        if ($this->codigo === $codigoGuardado) {
            // Código correcto: autenticar usuario definitivamente y borrar datos de sesión 2FA
            session()->forget(['2fa:user:id', '2fa:user:code']);

            // Aquí podrías, por ejemplo, marcar al usuario como 2FA verificado y redirigir
            return redirect()->route('dashboard'); // Cambia 'dashboard' por la ruta que quieras
        } else {
            // Código incorrecto: mostrar error
            $this->addError('codigo', 'El código introducido es incorrecto.');
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
