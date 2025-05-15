<div class="row">
    <!-- Sidebar con formulario -->
    <aside class="col-md-3 mb-4">
        <form class="p-5 rounded border bg-light" wire:submit.prevent="filter">

            <!-- Género -->
            <div class="mb-4">
                <h5>Género</h5>
                @foreach ($gendersList as $genero)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="gender" id="gender-{{ $genero }}"
                            value="{{ $genero }}">
                        <label class="form-check-label" for="gender-{{ $genero }}">{{ ucfirst($genero) }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Categoría -->
            <div class="mb-4">
                <h5>Categoría</h5>
                <div class="row">
                    @foreach ($categoriesList as $categoria)
                        <div class="col-6 col-md-4 col-lg-3 me-5 pe-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="categories"
                                    id="cat-{{ $categoria }}" value="{{ $categoria }}">
                                <label class="form-check-label"
                                    for="cat-{{ $categoria }}">{{ ucfirst($categoria) }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Color -->
            <div class="mb-4">
                <h5>Color</h5>
                <select class="form-select" wire:model="color">
                    <option value="">Todos</option>
                    @foreach ($colorsList as $colorItem)
                        <option value="{{ $colorItem }}">{{ ucfirst($colorItem) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Talla -->
            <div class="mb-4">
                <h5>Talla</h5>
                <div class="row">
                    @foreach ($availableSizes as $size)
                        <div class="col-6 col-md-4 col-lg-3 me-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="sizes"
                                    id="size-{{ $size->name }}" value="{{ $size->name }}">
                                <label class="form-check-label"
                                    for="size-{{ $size->name }}">{{ strtoupper($size->name) }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Estilo -->
            <div class="mb-4">
                <h5>Estilo</h5>
                @foreach ($stylesList as $styleItem)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="style"
                            id="style-{{ $styleItem }}" value="{{ $styleItem }}">
                        <label class="form-check-label"
                            for="style-{{ $styleItem }}">{{ ucfirst($styleItem) }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <h5>Precio</h5>
                <input type="number" wire:model="priceMin" class="form-control" placeholder="Precio mínimo"
                    min="0" step="0.01">
                <input type="number" wire:model="priceMax" class="form-control mt-2" placeholder="Precio máximo"
                    min="0" step="0.01">
            </div>

            <!-- Ofertas -->
            <div class="mb-4">
                <h5>Ofertas</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="onlyOffers" id="onlyOffers">
                    <label class="form-check-label" for="onlyOffers">
                        Mostrar solo productos en oferta
                    </label>
                </div>
            </div>


            <!-- Botones -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <button type="reset" class="btn btn-outline-secondary" wire:click="resetFilters">Borrar
                    filtros</button>
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
                        <!-- Mostrar la primera imagen -->
                        <img src="{{ $product->images->first()->url ?? 'default-image-url.jpg' }}" class="card-img-top"
                            alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>

                            @if ($product->discount > 0)
                                <p>
                                    <span
                                        class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }}€</span>
                                    <span
                                        class="fw-bold fs-5 text-danger ms-2">{{ number_format(($product->price - ($product->price * $product->discount) / 100), 2) }}€</span>
                                </p>
                            @else
                                <p class="fw-bold fs-5">{{ number_format($product->price, 2) }}€</p>
                            @endif

                            <div class="mt-auto">
                                <livewire:add-to-cart :product="$product" :key="'add-to-cart-' . $product->id . '-' . $loop->index" />
                                <a href="{{ route('productos.show', $product->id) }}"
                                    class="btn btn-outline-primary w-100 mt-3">Ver detalles del Producto</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
</div>
