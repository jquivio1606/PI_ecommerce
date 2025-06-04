<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
     public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        // Redirección según el rol
        if ($user->role == 1) {
            $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirect(route('user.index', absolute: false), navigate: true);
        }
    }
};
?>

<div class="flex flex-col gap-6">
    @section('title', 'Registrarse')
    <x-auth-header
        :title="__('Crear una cuenta')"
        :description="__('Introduce tus datos para crear tu cuenta')"
        title="Crear una cuenta"
        aria-label="Formulario para crear una cuenta"
    />

    <!-- Estado de sesión -->
    <x-auth-session-status
        class="text-center"
        :status="session('status')"
        role="alert"
        aria-live="polite"
    />

    <form wire:submit="register" class="flex flex-col gap-6" aria-label="Formulario de registro">
        <!-- Nombre -->
        <flux:input
            wire:model="name"
            :label="__('Nombre completo')"
            type="text"
            required
            autofocus
            autocomplete="name"
            placeholder="Nombre completo"
            title="Introduce tu nombre completo"
            aria-label="Nombre completo"
        />

        <!-- Correo electrónico -->
        <flux:input
            wire:model="email"
            :label="__('Correo electrónico')"
            type="email"
            required
            autocomplete="email"
            placeholder="correo@ejemplo.com"
            title="Introduce tu correo electrónico"
            aria-label="Correo electrónico"
        />

        <!-- Contraseña -->
        <flux:input
            wire:model="password"
            :label="__('Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Contraseña"
            title="Introduce tu contraseña"
            aria-label="Contraseña"
        />

        <!-- Confirmar contraseña -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmar contraseña')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Confirmar contraseña"
            title="Confirma tu contraseña"
            aria-label="Confirmar contraseña"
        />

        <div class="flex items-center justify-end">
            <flux:button
                type="submit"
                variant="primary"
                class="w-full"
            >
                {{ __('Crear cuenta') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400" aria-label="Enlace para iniciar sesión">
        {{ __('¿Ya tienes una cuenta?') }}
        <flux:link
            :href="route('login')"
            wire:navigate
            title="Iniciar sesión"
            aria-label="Enlace para iniciar sesión"
        >
            {{ __('Iniciar sesión') }}
        </flux:link>
    </div>
</div>
