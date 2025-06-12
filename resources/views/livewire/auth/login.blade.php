<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Mail\twoFACode;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Guarda la URL anterior (para redirigir después del login)
     */
    public function mount()
    {
        if (!session()->has('url.previous') && url()->previous() !== url()->current()) {
            session(['url.previous' => url()->previous()]);
        }
    }

    /**
     * Maneja la solicitud de autenticación entrante.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Genera código 2FA de 6 dígitos aleatorio
        $twoFACode = rand(100000, 999999);

        $user = Auth::user();

        // Guarda el id del usuario y código en sesión para validar en 2FA
        session([
            '2fa:user:id' => $user->id,
            '2fa:user:code' => (string) $twoFACode,
        ]);

        // Enviar correo con el código al administrador
        Mail::to($this->email)->send(new twoFACode($twoFACode));

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        redirect()->to(route('2fa'));
    }

    /**
     * Asegura que la solicitud de autenticación no esté limitada.
     */
    protected function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Obtiene la clave para limitar la tasa de autenticación.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
};
?>

<div class="flex flex-col gap-6">
    @section('title', 'Iniciar sesión')
    <x-auth-header :title="__('Inicia sesión en tu cuenta')" :description="__('Introduce tu correo y contraseña para acceder')" title="Inicia sesión en tu cuenta"
        aria-label="Formulario para iniciar sesión en tu cuenta" />

    <!-- Estado de sesión -->
    <x-auth-session-status class="text-center" :status="session('status')" role="alert" aria-live="polite" />

    <form wire:submit="login" class="flex flex-col gap-6" aria-label="Formulario de inicio de sesión">
        <!-- Correo electrónico -->
        <flux:input wire:model="email" :label="__('Correo electrónico')" type="email" required autofocus
            autocomplete="email" placeholder="correo@ejemplo.com" title="Introduce tu correo electrónico"
            aria-label="Correo electrónico" />

        <!-- Contraseña -->
        <div class="relative">
            <flux:input wire:model="password" :label="__('Contraseña')" type="password" required
                autocomplete="current-password" :placeholder="__('Contraseña')" title="Introduce tu contraseña"
                aria-label="Contraseña" />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate
                    title="¿Olvidaste tu contraseña?" aria-label="Enlace ¿Olvidaste tu contraseña?">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </flux:link>
            @endif
        </div>

        <!-- Recuérdame -->
        <flux:checkbox wire:model="remember" :label="__('Recuérdame')" title="Recuérdame"
            aria-label="Casilla para recordar sesión" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Iniciar sesión') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400"
            aria-label="Enlace para registrarse">
            {{ __('¿No tienes una cuenta?') }}
            <flux:link :href="route('register')" wire:navigate title="Regístrate" aria-label="Regístrate enlace">
                {{ __('Regístrate') }}
            </flux:link>
        </div>
    @endif
</div>
