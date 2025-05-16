<x-layouts.app :title="__('Mi perfil')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Encabezado con datos del usuario -->
        <div
            class="flex items-center gap-6 p-6 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-md">
            <img src="https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png"
            alt="Foto de perfil" class="w-12 h-12 rounded-full border-2 border-indigo-500 shadow" style="width: 125px; height: 125px;">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">¡Hola, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 dark:text-gray-300">Miembro desde {{ ucfirst(Auth::user()->created_at->translatedFormat('F \d\e Y')) }}</p>
                </p>
                <p class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 font-medium"><a href=" {{ route ('settings.profile') }}">Editar perfil</a></p>
            </div>
        </div>

        <!-- Tarjetas informativas -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="bg-white dark:bg-neutral-900 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Mis pedidos</h3>
                @php
                    $orders = Auth::user()->orders; // Relación de pedidos
                    $lastOrder = $orders->last(); // Último pedido
                @endphp
                <p class="text-sm text-gray-600 dark:text-gray-300">Último pedido:
                    {{ $lastOrder ? $lastOrder->created_at->format('d/m/Y') : 'No tienes pedidos' }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">Total pedidos: {{ $orders->count() }}</p>
                <a href="{{ route('user.orders') }}"
                    class="text-sm text-indigo-600 dark:text-indigo-400 font-medium mt-2 inline-block">Ver historial</a>
            </div>
            <div
                class="bg-white dark:bg-neutral-900 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Carrito</h3>
                @php
                    $cart = Auth::user()->cart; // Relación de carrito
                    $cartItems = $cart ? $cart->items : collect(); // Artículos en el carrito
                @endphp
                <p class="text-sm text-gray-600 dark:text-gray-300">Tienes {{ $cartItems->count() }} artículos en tu
                    carrito</p>
                <a href="{{ route('user.cart') }}"
                    class="text-sm text-indigo-600 dark:text-indigo-400 font-medium mt-2 inline-block">Ver carrito</a>
            </div>
            <div
                class="bg-white dark:bg-neutral-900 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Direcciones</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Última dirección usada:</p>
                    <a href="#"
                        class="text-sm text-indigo-600 dark:text-indigo-400 font-medium mt-2 inline-block">Gestionar
                        direcciones</a>
            </div>
        </div>

        <!-- Información adicional o actividades recientes -->
        <div
            class="bg-white dark:bg-neutral-900 p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Actividad reciente</h3>
            <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                @foreach ($orders as $order)
                    <li>📦 Pedido #{{ $order->id }} realizado el {{ $order->created_at->format('d/m/Y') }}</li>
                @endforeach
                @foreach ($cartItems as $item)
                    <li>🛒 Añadiste {{ $item->product->name }} al carrito</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layouts.app>
