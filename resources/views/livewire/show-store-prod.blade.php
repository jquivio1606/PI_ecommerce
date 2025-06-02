<div class="row">
    <!-- Sidebar con formulario -->
    <aside class="col-md-3 mb-4">
        <form class="p-5 rounded border bg-light" wire:submit.prevent="filter"
            aria-label="Formulario de filtro de productos">

            <!-- Género -->
            <div class="mb-4">
                <h3 class="h5">Género</h3 class="h5">
                @foreach ($gendersList as $genero)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="gender"
                            id="gender-{{ $genero }}" name="gender" value="{{ $genero }}"
                            aria-label="Género {{ $genero }}" title="Género {{ $genero }}">
                        <label class="form-check-label" for="gender-{{ $genero }}">{{ ucfirst($genero) }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Categoría -->
            <div class="mb-4">
                <h3 class="h5">Categoría</h3 class="h5">
                <div class="row">
                    @foreach ($categoriesList as $categoria)
                        <div class="col-6 col-md-4 col-lg-3 me-5 pe-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="categories"
                                    id="cat-{{ $categoria }}" name="categories[]" value="{{ $categoria }}"
                                    aria-label="Categoría {{ $categoria }}" title="Categoría {{ $categoria }}">
                                <label class="form-check-label"
                                    for="cat-{{ $categoria }}">{{ ucfirst($categoria) }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Color -->
            <div class="mb-4">
                <h3 class="h5">Color</h3 class="h5">
                <select class="form-select" wire:model="color" name="color" id="color"
                    aria-label="Filtrar por color" title="Selecciona un color">
                    <option value="">Todos</option>
                    @foreach ($colorsList as $colorItem)
                        <option value="{{ $colorItem }}">{{ ucfirst($colorItem) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Talla -->
            <div class="mb-4">
                <h3 class="h5">Talla</h3 class="h5">
                <div class="row">
                    @foreach ($availableSizes as $size)
                        <div class="col-6 col-md-4 col-lg-3 me-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="sizes"
                                    id="size-{{ $size->name }}" name="sizes[]" value="{{ $size->name }}"
                                    aria-label="Talla {{ strtoupper($size->name) }}"
                                    title="Talla {{ strtoupper($size->name) }}">
                                <label class="form-check-label"
                                    for="size-{{ $size->name }}">{{ strtoupper($size->name) }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Estilo -->
            <div class="mb-4">
                <h3 class="h5">Estilo</h3 class="h5">
                @foreach ($stylesList as $styleItem)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="style"
                            id="style-{{ $styleItem }}" name="style" value="{{ $styleItem }}"
                            aria-label="Estilo {{ $styleItem }}" title="Estilo {{ $styleItem }}">
                        <label class="form-check-label"
                            for="style-{{ $styleItem }}">{{ ucfirst($styleItem) }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <h3 class="h5">Precio</h3 class="h5">
                <input type="number" wire:model="priceMin" class="form-control" placeholder="Precio mínimo"
                    id="priceMin" name="priceMin" min="0" step="0.01" aria-label="Precio mínimo"
                    title="Precio mínimo">
                <input type="number" wire:model="priceMax" class="form-control mt-2" placeholder="Precio máximo"
                    id="priceMax" name="priceMax" min="0" step="0.01" aria-label="Precio máximo"
                    title="Precio máximo">
            </div>

            <!-- Ofertas -->
            <div class="mb-4">
                <h3 class="h5">Ofertas</h3 class="h5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="onlyOffers" id="onlyOffers"
                        name="onlyOffers" aria-label="Solo productos en oferta"
                        title="Mostrar solo productos en oferta">
                    <label class="form-check-label" for="onlyOffers">Mostrar solo productos en oferta</label>
                </div>
            </div>

            <!-- Botones -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" aria-label="Filtrar" title="Filtrar">Filtrar</button>
                <button type="reset" class="btn btn-outline-dark"
                    onmouseover="this.classList.replace('btn-outline-dark','btn-outline-secondary')"
                    onmouseout="this.classList.replace('btn-outline-secondary','btn-outline-dark')"
                    wire:click="resetFilters" aria-label="Borrar filtros" title="Borrar filtros">
                    Borrar filtros
                </button>

            </div>
        </form>
    </aside>

    <!-- Contenido principal -->
    <section class="col-md-9">
        <div class="row">
            <!-- Fila de productos -->
            @foreach ($prodFiltrado ?? $products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $product->images->first()->url) }}"  class="card-img-top"
                            alt="Imagen de {{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h3 class="h5" class="card-title">{{ $product->name }}</h3 class="h5">
                            <p class="card-text">{{ $product->description }}</p>

                            @if ($product->discount > 0)
                                <p>
                                    <span class="text-muted text-decoration-line-through">
                                        {{ number_format($product->price, 2) }}€
                                    </span>
                                    <span class="fw-bold fs-5 text-danger ms-2">
                                        {{ number_format($product->price - ($product->price * $product->discount) / 100, 2) }}€
                                    </span>
                                </p>
                            @else
                                <p class="fw-bold fs-5">{{ number_format($product->price, 2) }}€</p>
                            @endif

                            <div class="mt-auto">
                                <livewire:add-to-cart :product="$product" :key="'add-to-cart-' . $product->id . '-' . $loop->index" />
                                <a href="{{ route('productos.show', $product->id) }}"
                                    class="btn btn-outline-primary w-100 mt-3"
                                    aria-label="Ver detalles del producto {{ $product->name }}"
                                    title="Ver detalles del producto {{ $product->name }}">Ver detalles del
                                    Producto</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
