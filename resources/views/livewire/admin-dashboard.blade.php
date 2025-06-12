<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <!-- Encabezado con datos del administrador -->
    <div
        class="flex items-center gap-6 p-6 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-md">
        <img src="https://www.shutterstock.com/image-vector/admin-icon-strategy-collection-thin-600nw-2307398667.jpg"
            alt="Foto de perfil" class="w-16 h-16 rounded-full border-4 border-indigo-500 shadow"
            style="width: 125px; height: 125px;">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">¡Hola, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-600 dark:text-gray-300">Administrador desde
                {{ ucfirst(Auth::user()->created_at->translatedFormat('F \d\e Y')) }}</p>
            <p class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 font-medium"><a
                    href="{{ route('settings.profile') }}">Editar perfil</a></p>
        </div>
    </div>

    <!-- Tarjetas informativas -->
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div
            class="bg-white dark:bg-neutral-900 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Gestión de Productos</h3>
            @if ($products->count())
                <p class="text-sm text-gray-600 dark:text-gray-300">Total de productos en la tienda:
                    {{ $products->count() }}</p>
            @else
                <p>No hay productos en la tienda.</p>
            @endif

            <a href="{{ route('admin.product') }}"
                class="text-sm text-indigo-600 dark:text-indigo-400 font-medium mt-2 inline-block">Ver productos</a>
        </div>
        <div
            class="bg-white dark:bg-neutral-900 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Gestión de Pedidos</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Total de pedidos realizados: {{ $orders->count() }}
            </p>
            <a href="{{ route('admin.order') }}"
                class="text-sm text-indigo-600 dark:text-indigo-400 font-medium mt-2 inline-block">Ver pedidos</a>
        </div>
        <div
            class="bg-white dark:bg-neutral-900 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Usuarios Registrados</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Total de usuarios: {{ $users->count() }}</p>
            <a href="{{ route('admin.users') }}"
                class="text-sm text-indigo-600 dark:text-indigo-400 font-medium mt-2 inline-block">Ver
                usuarios</a>
        </div>
    </div>

    <!-- Información adicional o actividades recientes -->
    <div
        class="bg-white dark:bg-neutral-900 p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-md">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Actividad reciente</h3>
        <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
            @foreach ($recentOrders as $order)
                <li>📦 Pedido #{{ $order->id }} realizado el {{ $order->created_at->format('d/m/Y') }}</li>
            @endforeach
            @foreach ($recentProducts as $product)
                <li>🛒 Producto {{ $product->name }} añadido el {{ $product->created_at->format('d/m/Y') }}</li>
            @endforeach
        </ul>
    </div>

    @if ($lowStockProducts->count() > 0)
        <div class="alert alert-warning shadow-sm">
            <h3 class="h5"><i class="bi bi-exclamation-triangle-fill me-2"></i>Productos con poco stock:</h3>
            <ul class="mb-0">
                @foreach ($lowStockProducts as $product)
                    <li>
                        <strong>{{ $product->name }}</strong>
                        <ul>
                            @foreach ($product->sizes as $size)
                                @if ($size->pivot->stock <= 5)
                                    <li>
                                        <strong>{{ $size->name }}:</strong> {{ $size->pivot->stock }} unidades
                                        restantes
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="alert alert-success shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>Todos los productos tienen suficiente stock.
        </div>
    @endif



</div>
