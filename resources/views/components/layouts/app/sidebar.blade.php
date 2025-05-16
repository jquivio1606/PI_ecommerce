<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <span class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </span>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Tienda')" class="grid">
                        <flux:navlist.item class="text-dark text-decoration-none" :href="route('user.index')" :current="request()->routeIs('user.index')" wire:navigate>{{ __('Ir a la Tienda') }}</flux:navlist.item>
                </flux:navlist.group>

                <br>

                @if (Auth::check() && Auth::user()->role== 1)
                    <flux:navlist.group :heading="__('Panel de administrador')" class="grid">
                        <flux:navlist.item  icon="home" class="text-dark text-decoration-none" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>{{ __('Panel de administrador') }}</flux:navlist.item>
                    </flux:navlist.group>

                    <br>

                    <flux:navlist.group :heading="__('Opciones de administrador')" class="grid">
                        <flux:navlist.item class="text-dark text-decoration-none d-flex align-items-center gap-2" :href="route('admin.product')" :current="request()->routeIs('admin.product')" wire:navigate>
                            <i class="bi bi-box-seam me-2"></i> {{ __('Información Productos') }}
                        </flux:navlist.item>

                        <flux:navlist.item class="text-dark text-decoration-none d-flex align-items-center gap-2" :href="route('admin.order')" :current="request()->routeIs('admin.order')" wire:navigate>
                            <i class="bi bi-cart-check me-2"></i> {{ __('Información Pedidos') }}
                        </flux:navlist.item>

                        <flux:navlist.item class="text-dark text-decoration-none d-flex align-items-center gap-2" :href="route('admin.users')" :current="request()->routeIs('admin.users')" wire:navigate>
                            <i class="bi bi-box-seam me-2"></i> {{ __('Información Usuarios') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @else
                    <flux:navlist.group :heading="__('Perfil')" class="grid">
                        <flux:navlist.item  icon="home" class="text-dark text-decoration-none" :href="route('user.profile')" :current="request()->routeIs('user.profile')" wire:navigate>{{ __('Perfil') }}</flux:navlist.item>
                    </flux:navlist.group>

                    <br>

                    <flux:navlist.group :heading="__('Información del usuario')" class="grid">
                        <flux:navlist.item class="text-dark text-decoration-none d-flex align-items-center gap-2" :href="route('user.orders')" :current="request()->routeIs('user.orders')" wire:navigate>
                            <i class="bi bi-cart-check me-2"></i> {{ __('Mis Pedidos') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Menú de usuario de escritorio -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item class="text-dark text-decoration-none" :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Configuración') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Menú de usuario móvil -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item class="text-dark text-decoration-none" :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Configuración') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
