<!-- Navbar -->
<nav class="bg-white py-2 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Izquierda: enlaces -->
        <div>
            <a href="{{ route('user.index') }}" class="me-3 text-decoration-none text-dark active">Inicio</a>
            <a href="{{ route('user.tienda') }}" class="me-3 text-decoration-none text-dark">Tienda</a>
            <a href="{{ route('user.aboutUs') }}" class="text-decoration-none text-dark">Sobre Nosotros</a>
        </div>
        <!-- Derecha: buscador + carrito -->
        <div class="d-flex align-items-center">
            @if (auth()->check())
                <!-- Aquí va todo el contenido del carrito -->
                    <a href="{{ route('user.cart')}}" class="btn btn-outline-secondary">
                        <i class="bi bi-cart"></i>
                    </a>
            @else
                <!-- Opcional: Mostrar un mensaje si no está autenticado -->
                <div class="alert alert-warning text-center m-0 p-2" style="font-size: x-small; width: 100%; max-width: 300px;">
                    Inicia sesión para ver tu carrito.
                </div>
            @endif
        </div>
    </div>
</nav>
