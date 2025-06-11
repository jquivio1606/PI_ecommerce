<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <style>
        div.z-10.fixed {
            left: 255px !important;
            width: calc(100% - 255px) !important;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <!-- Menú de usuario móvil -->
    <flux:header class="lg:hidden border-b border-zinc-200 bg-zinc-50" aria-label="Menú de usuario móvil">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" title="Abrir menú lateral"
            aria-label="Abrir menú lateral" />

        <flux:spacer />

        <flux:dropdown position="top" align="end" aria-label="Menú desplegable de perfil de usuario">
            <flux:profile :initials="auth() -> user() -> initials()" icon-trailing="chevron-down"
                title="{{ auth()->user()->initials() }} - Perfil de usuario"
                aria-label="{{ auth()->user()->initials() }} - Perfil de usuario" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm"
                            aria-label="Información del usuario autenticado">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg" aria-hidden="true">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                    <flux:menu.item class="text-dark text-decoration-none" :href="route('settings.profile')"
                        icon="cog" wire:navigate title="Configuración del perfil"
                        aria-label="Configuración del perfil">{{ __('Configuración') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        title="Cerrar sesión" aria-label="Cerrar sesión">
                        {{ __('Cerrar sesión') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>



    <div class="flex h-auto min-h-screen cont1">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900"
            aria-label="Barra lateral de navegación principal">
            <flux:sidebar.toggle class="lg:hidden bi bi-x fs-3" title="Cerrar menú lateral"
                aria-label="Cerrar menú lateral" />


            <span class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate
                aria-label="Logo de la aplicación">
                <x-app-logo alt="Logo de la tienda" title="Logo de la tienda" />
            </span>

            <flux:navlist variant="outline" aria-label="Navegación principal">
                <flux:navlist.group :heading="__('Tienda')" class="grid fw-bold" aria-label="Sección Tienda">
                    <flux:navlist.item
                        class="text-dark text-decoration-none border border-1 border-dark-subtle shadow-sm rounded"
                        :href="route('user.index')" :current="request() -> routeIs('user.index')" wire:navigate
                        title="Ir a la página principal de la tienda" aria-label="Ir a la Tienda">
                        {{ __('Ir a la Tienda') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <br />

                @if (Auth::check() && Auth::user()->role == 1)
                    <flux:navlist.group :heading="__('Panel de administrador')" class="grid fw-bold"
                        aria-label="Sección Panel de administrador">
                        <flux:navlist.item icon="home"
                            class="text-dark text-decoration-none  border border-1 border-dark-subtle shadow-sm rounded"
                            :href="route('admin.dashboard')" :current="request() -> routeIs('admin.dashboard')"
                            wire:navigate title="Ir al panel de administrador" aria-label="Panel de administrador">
                            {{ __('Panel de administrador') }}
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <br />

                    <flux:navlist.group :heading="__('Opciones de administrador')" class="grid fw-bold"
                        aria-label="Opciones para administrador">
                        <flux:navlist.item
                            class="text-dark text-decoration-none d-flex align-items-center gap-2  border border-1 border-dark-subtle shadow-sm rounded"
                            :href="route('admin.product')" :current="request() -> routeIs('admin.product')"
                            wire:navigate title="Información de productos" aria-label="Información Productos">
                            <i class="bi bi-box-seam me-2" aria-hidden="true"></i> {{ __('Información Productos') }}
                        </flux:navlist.item>

                        <flux:navlist.item
                            class="text-dark text-decoration-none d-flex align-items-center gap-2 border border-1 border-dark-subtle shadow-sm rounded"
                            :href="route('admin.order')" :current="request() -> routeIs('admin.order')" wire:navigate
                            title="Información de pedidos" aria-label="Información Pedidos">
                            <i class="bi bi-cart-check me-2" aria-hidden="true"></i> {{ __('Información Pedidos') }}
                        </flux:navlist.item>

                        <flux:navlist.item
                            class="text-dark text-decoration-none d-flex align-items-center gap-2 border border-1 border-dark-subtle shadow-sm rounded"
                            :href="route('admin.users')" :current="request() -> routeIs('admin.users')" wire:navigate
                            title="Información de usuarios" aria-label="Información Usuarios">
                            <i class="bi bi-box-seam me-2" aria-hidden="true"></i> {{ __('Información Usuarios') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @else
                    <flux:navlist.group :heading="__('Perfil')" class="grid" aria-label="Sección Perfil de usuario">
                        <flux:navlist.item icon="home"
                            class="text-dark text-decoration-none border border-1 border-dark-subtle shadow-sm rounded"
                            :href="route('user.profile')" :current="request() -> routeIs('user.profile')"
                            wire:navigate title="Ir al perfil de usuario" aria-label="Perfil">
                            {{ __('Perfil') }}
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <br />

                    <flux:navlist.group :heading="__('Información del usuario')" class="grid fw-bold"
                        aria-label="Información del usuario">
                        <flux:navlist.item
                            class="text-dark text-decoration-none d-flex align-items-center gap-2 border border-1 border-dark-subtle shadow-sm rounded"
                            :href="route('user.orders')" :current="request() -> routeIs('user.orders')" wire:navigate
                            title="Ver mis pedidos" aria-label="Mis Pedidos">
                            <i class="bi bi-cart-check me-2" aria-hidden="true"></i> {{ __('Mis Pedidos') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Menú de usuario de escritorio -->
            <flux:dropdown position="bottom" align="start" aria-label="Menú desplegable de usuario de escritorio">
                <flux:profile :name="auth() -> user() -> name" :initials="auth() -> user() -> initials()"
                    icon-trailing="chevrons-up-down"
                    title="{{ auth()->user()->initials() }} - {{ auth()->user()->name }} - Perfil de usuario"
                    class="border border-1 border-dark-subtle shadow-sm rounded"
                    aria-label="{{ auth()->user()->initials() }} - {{ auth()->user()->name }} - Perfil de usuario" />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group class="w-[280px]">
                        <div class="p-0 text-sm font-normal m-0 w-[280px]"
                            aria-label="Información del usuario autenticado">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg"
                                    aria-hidden="true">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                        <flux:menu.item class="text-dark text-decoration-none" :href="route('settings.profile')"
                            icon="cog" style="outline: none;" onfocus="this.style.outline='1px solid #000'"
                            onblur="this.style.outline='none'" wire:navigate title="Configuración del perfil"
                            aria-label="Configuración del perfil">{{ __('Configuración') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            style="outline: none;" onfocus="this.style.outline='1px solid #000'"
                            onblur="this.style.outline='none'" class="w-full rounded text-dark text-decoration-none"
                            title="Cerrar sesión" aria-label="Cerrar sesión">
                            {{ __('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Contenido principal y footer -->
        <div class="flex-1 flex flex-col">
            <!-- Contenido dinámico -->
            <main class="flex-1" tabindex="-1">
                {{ $slot }}
            </main>

            <!-- Footer fijo abajo dentro del contenido -->
            @include('components.layouts.footer')
        </div>
    </div>

    @fluxScripts
</body>

</html>
