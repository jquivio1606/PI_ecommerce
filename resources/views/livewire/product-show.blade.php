<div class="row">
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3" style="width: 100px;" title="Volver atrás"
        aria-label="Volver a la página anterior">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <div class="row">
        <div class="col-md-4 mb-4">
            @if ($product && $product->images->count() > 0)
                @if ($product->images->count() === 1)
                    {{-- Solo una imagen --}}
                    <img src="{{ asset('storage/' . $product->images->first()->url) }}"
                        alt="Imagen de {{ $product->name }} - {{ $product->category }}, para {{ $product->gender }}"
                        aria-label="Imagen del producto {{ $product->name }}"
                        title="Imagen del producto {{ $product->name }}" class="img-fluid rounded shadow-sm" />
                @else
                    {{-- Carrusel Bootstrap --}}
                    <div id="carouselProductImages{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded shadow-sm">
                            @foreach ($product->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->url) }}" class="d-block w-100"
                                        alt="Imagen {{ $index + 1 }} de {{ $product->name }}"
                                        aria-label="Imagen {{ $index + 1 }} del producto {{ $product->name }}"
                                        title="Imagen {{ $index + 1 }} del producto {{ $product->name }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Flecha izquierda -->
                        <button class="carousel-control-prev" type="button"
                            style="background-color: rgba(255, 255, 255, 0.7);"
                            data-bs-target="#carouselProductImages{{ $product->id }}" data-bs-slide="prev"
                            title="Imagen anterior" aria-label="Imagen anterior">
                            <span class="carousel-control-prev-icon" style="filter: invert(1);"
                                aria-hidden="true"></span>
                        </button>

                        <!-- Flecha derecha -->
                        <button class="carousel-control-next" type="button"
                            style="background-color: rgba(255, 255, 255, 0.7);"
                            data-bs-target="#carouselProductImages{{ $product->id }}" data-bs-slide="next"
                            title="Imagen siguiente" aria-label="Imagen siguiente">
                            <span class="carousel-control-next-icon" style="filter: invert(1);"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                @endif
            @else
                <p>No hay imágenes disponibles para este producto.</p>
            @endif
        </div>

        <div class="col-md-8">
            <h3>{{ $product->name }}</h3>
            <p class="text-muted">Categoría: {{ $product->category }} / {{ $product->gender }}</p>

            <!-- Descripción larga -->
            <p>{{ $product->description }}</p>

            <!-- Precio -->
            @if ($product->discount > 0)
                <p>
                    <span
                        class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }}€</span>
                    <span
                        class="fw-bold fs-5 text-danger ms-2">{{ number_format($product->price - ($product->price * $product->discount) / 100, 2) }}€</span>
                </p>
            @else
                <p class="fw-bold fs-5">{{ number_format($product->price, 2) }}€</p>
            @endif

            <livewire:add-to-cart :product="$product" />
        </div>
    </div>

</div>
