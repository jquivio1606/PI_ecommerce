<!-- Navbar -->
<nav class="bg-white py-2 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Izquierda: enlaces -->
        <div>
            <a href="{{ route('user.index')}}" class="me-3 text-decoration-none text-dark active">Inicio</a>
            <a href="{{ route('user.tienda')}}" class="me-3 text-decoration-none text-dark">Tienda</a>
            <a href="{{ route('user.sobreNosotros')}}" class="text-decoration-none text-dark">Sobre Nosotros</a>
        </div>
        <!-- Derecha: buscador + carrito -->
        <div class="d-flex align-items-center">
            <input type="text" class="form-control me-2" placeholder="Buscar..." style="max-width: 200px;" />
            <a href="{{ route('user.carrito')}}" class="btn btn-outline-secondary">
                <i class="bi bi-cart"></i>
            </a>
        </div>
    </div>
</nav>
