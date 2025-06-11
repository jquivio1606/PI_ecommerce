<!-- Navbar -->
<nav class="bg-white py-2 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Enlaces -->
        <div>
            <a href="{{ route('user.index') }}" class="me-3 p-1 text-decoration-none text-dark active" title="Ir a la página de inicio" aria-label="Inicio">Inicio</a>
            <a href="{{ route('user.tienda') }}" class="me-3 p-1 text-decoration-none text-dark" title="Ir a la tienda" aria-label="Tienda">Tienda</a>
            <a href="{{ route('user.aboutUs') }}" class="p-1 text-decoration-none text-dark" title="Saber más sobre nosotros" aria-label="Sobre Nosotros">Sobre Nosotros</a>
        </div>
        <!-- Botón del carrito/mensaje autenticación -->
        <div class="d-flex align-items-center">
            @if (auth()->check())
                <a href="{{ route('user.cart')}}" class="btn btn-outline-dark" title="Ver carrito" aria-label="Carrito de compras">
                    <i class="bi bi-cart" aria-hidden="true"></i> Carrito
                </a>
            @else
                <div class="alert alert-warning text-center m-0 p-2" style="font-size: x-small; width: 100%; max-width: 300px;" role="alert" aria-live="polite">
                    Inicia sesión para ver tu carrito.
                </div>
            @endif
        </div>
    </div>
</nav>
