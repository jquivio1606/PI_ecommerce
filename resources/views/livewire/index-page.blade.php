<div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif


    <!-- 1. CARRUSEL NOVEDADES -->
    <div class="d-flex justify-content-center position-relative my-4">
        <div id="carouselNovedades" class="carousel slide w-75" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($newProducts as $index => $product)
                    <div class="carousel-item @if ($index == 0) active @endif">
                        <div class="row g-0 align-items-center mb-5">
                            <!-- Imagen con cartel de Novedades -->
                            <div
                                class="col-12 col-md-6 position-relative d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/' . optional($product->images->first())->url) }}"
                                    class="img-fluid w-100 object-fit-cover rounded-start" style="max-height: 600px"
                                    alt="{{ $product->name }}">
                            </div>

                            <!-- Info del producto al lado -->
                            <div
                                class="col-12 col-md-6 d-flex flex-column justify-content-center gap-2 align-items-center text-center p-4">
                                <h3 class="fw-bold">{{ $product->name }}</h3>
                                <p class="text-muted fs-5 fst-italic">{{ $this->getProductDescription($product) }}</p>
                                <a href="{{ route('productos.show', $product->id) }}" class="btn btn-primary mt-3">Ver
                                    Producto</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Flecha izquierda -->
        <button class="carousel-control-prev position-absolute top-50 p-2"
            style="max-height: fit-content; width: fit-content; left: 20px; transform: translateY(-50%);" type="button"
            data-bs-target="#carouselNovedades" data-bs-slide="prev" title="Producto anterior"
            aria-label="Producto anterior">
            <span class="carousel-control-prev-icon" style="filter: invert(1);" aria-hidden="true"></span>
        </button>

        <!-- Flecha derecha -->
        <button class="carousel-control-next position-absolute top-50 p-2"
            style="max-height: fit-content; width: fit-content; right: 20px; transform: translateY(-50%);"
            type="button" data-bs-target="#carouselNovedades" data-bs-slide="next" title="Producto siguiente"
            aria-label="Producto siguiente">
            <span class="carousel-control-next-icon" style="filter: invert(1);" aria-hidden="true"></span>
        </button>
    </div>


    <!-- 2. Tarjetas de relleno -->
    <h2 class="mb-4 text-center fw-bold">Lo que nos hace únicos</h2>
    <div class="row my-5 text-center">
        <div class="col-md-3 mb-4">
            <i class="bi bi-palette-fill" style="font-size: 60px;"></i>
            <h3 class="fw-bold h5 mt-3">Variedad de Estilos</h3>
            <p>Desde casual hasta elegante, para todos los gustos y ocasiones.</p>
        </div>
        <div class="col-md-3 mb-4">
            <i class="bi bi-tags" style="font-size: 60px;"></i>
            <h3 class="fw-bold h5 mt-3">Precios Accesibles</h5>
                <p>Moda de calidad que cuida tu bolsillo sin sacrificar estilo.</p>
        </div>
        <div class="col-md-3 mb-4">
            <i class="bi bi-rulers" style="font-size: 60px;"></i>
            <h3 class="fw-bold h5 mt-3">Tallas para Todos</h5>
                <p>Variedad en tallas y colores para que encuentres tu prenda ideal.</p>
        </div>
        <div class="col-md-3 mb-4">
            <i class="bi bi-truck" style="font-size: 60px;"></i>
            <h3 class="fw-bold h5 mt-3">Envíos Rápidos</h5>
                <p>Compra fácil y recibe tu pedido en tiempo récord.</p>
        </div>
    </div>

    <br>

    <!-- 3. OFERTAS -->
    <h2 class="mb-5 text-center fw-bold">Ofertas</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($discountedProducts as $product)
            <div class="col">
                <a href="{{ route('productos.show', $product->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . optional($product->images->first())->url) }}"
                            class="card-img-top img-fluid" alt="{{ $product->name }}"
                            style="object-fit: cover; height: 180px;">
                        <div class="card-body d-flex flex-column">
                            <p class="h5 card-title">{{ $product->name }}</p>
                            <p class="card-text text-truncate" style="max-height: 4.5rem;">
                                {{ $product->description }}</p>
                            <p class="card-text">Tallas disponibles:
                                {{ $product->sizes->pluck('name')->join(', ') . '.' }}</p>
                            <p class="mb-0">
                                <span
                                    class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }}€</span>
                                <span class="fw-bold text-danger ms-4 fs-4 ms-2">
                                    {{ number_format($product->price * (1 - $product->discount / 100), 2) }}€
                                </span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
