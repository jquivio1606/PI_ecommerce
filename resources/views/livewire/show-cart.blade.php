<div>

    @if ($message)
        <div class="alert alert-{{ $messageType == 'success' ? 'success' : ($messageType == 'warning' ? 'warning' : 'danger') }} mb-4"
            role="alert" aria-live="assertive" aria-atomic="true" title="Mensaje de estado">
            {{ $message }}
        </div>
    @endif


    <div class="row" role="list" aria-label="Lista de productos en el carrito">
        @foreach ($cartItems as $item)
            <div class="col-12 mb-3" role="listitem">
                <div class="card p-3" aria-label="Producto {{ $item->product->name }}">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <!-- Checkbox -->
                            <input type="checkbox" wire:click="itemSelection({{ $item->id }})"
                                {{ in_array($item->id, $selectedItems) ? 'checked' : '' }}
                                aria-label="Seleccionar producto {{ $item->product->name }}"
                                title="Seleccionar producto {{ $item->product->name }}">
                        </div>

                        <!-- Imagen del producto -->
                        <div class=" col-3 d-flex justify-content-center">
                            <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                alt="Imagen de {{ $item->product->name }} - {{ $item->product->category }}, para {{ $item->product->gender }}"
                                aria-label="Imagen del producto {{ $item->product->name }}"
                                title="Imagen del producto {{ $item->product->name }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                        </div>


                        <!-- Descripción del producto -->
                        <div class="col" role="region"
                            aria-label="Detalles del producto {{ $item->product->name }}">
                            <h3 class="h5">{{ $item->product->name }}</h5>
                                <p class="text-muted">{{ $item->product->description }}</p>

                                <!-- Talla y Cantidad en dos columnas -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="size-{{ $item->id }}"
                                                title="Etiqueta para talla del producto {{ $item->product->name }}">
                                                Talla
                                            </label>
                                            <select wire:model="size" class="form-control"
                                                id="size-{{ $item->id }}"
                                                wire:change="updateCartItem({{ $item->id }}, {{ $item->quantity }}, $event.target.value)"
                                                aria-label="Seleccionar talla para {{ $item->product->name }}"
                                                title="Seleccionar talla para {{ $item->product->name }}">
                                                @foreach ($item->product->sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        {{ $size->id == $item->size_id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity-{{ $item->id }}"
                                                title="Etiqueta para cantidad del producto {{ $item->product->name }}">
                                                Cantidad
                                            </label>
                                            <input type="number" wire:model="quantity" min="1"
                                                class="form-control" id="quantity-{{ $item->id }}"
                                                value="{{ $item->quantity }}"
                                                wire:change="updateCartItem({{ $item->id }}, $event.target.value, {{ $item->size_id }})"
                                                aria-label="Cantidad para {{ $item->product->name }}"
                                                title="Cantidad para {{ $item->product->name }}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <!-- Precio -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="fs-6 fw-semibold"
                                            aria-label="Precio unidad del producto {{ $item->product->name }}">
                                            Precio Unidad:
                                            @if ($item->product->discount)
                                                <span class="text-muted text-decoration-line-through"
                                                    aria-label="Precio original tachado">
                                                    {{ number_format($item->product->price, 2) }} €
                                                </span>
                                                <span class="text-danger fw-bold fs-5"
                                                    aria-label="Precio con descuento">
                                                    {{ number_format($item->product->price * (1 - $item->product->discount / 100), 2) }}
                                                    €
                                                </span>
                                            @else
                                                {{ number_format($item->product->price, 2) }} €
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="fs-6 fw-semibold"
                                            aria-label="Precio total del producto {{ $item->product->name }}">
                                            Precio Total:
                                            {{ number_format($item->product->price * (1 - $item->product->discount / 100) * $item->quantity, 2) }}
                                            €
                                        </p>
                                    </div>
                                </div>
                        </div>

                        <!-- Botones: Ver producto y Eliminar producto -->
                        <div class="col-auto d-flex justify-content-around flex-column" role="group"
                            aria-label="Acciones para el producto {{ $item->product->name }}">
                            <a href="{{ route('productos.show', $item->product->id) }}"
                                class="btn btn-outline-primary mb-2" aria-label="Ver Producto" title="Ver Producto">
                                <i class="bi bi-eye" aria-hidden="true"></i> Ver Producto
                            </a>
                            <a wire:click="confirmDeletion({{ $item->id }})" class="btn btn-danger mt-2"
                                role="button" tabindex="0"
                                aria-label="Eliminar producto {{ $item->product->name }} del carrito"
                                title="Eliminar producto {{ $item->product->name }} del carrito">
                                <i class="bi bi-cart-dash" aria-hidden="true"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="bg-light py-4 mt-4 border border-subtle rounded" role="contentinfo"
            aria-label="Resumen de pedido y acciones" style="position: sticky; bottom: 0; z-index: 1020;">
            <div class="d-flex gap-5 justify-content-end align-items-center" role="region" aria-live="polite"
                aria-atomic="true">
                <p class="text-right me-5 m-0" aria-label="Cantidad de productos seleccionados">
                    <strong>Cantidad de productos seleccionados: {{ count($selectedItems) }}</strong>
                </p>
                <p class="text-right me-5 m-0" aria-label="Precio total de productos seleccionados">
                    <strong>Total: {{ number_format($totalPrice, 2) }} €</strong>
                </p>
                <button class="btn btn-primary me-3" wire:click="makeOrder" aria-label="Realizar pedido"
                    title="Realizar pedido">
                    Realizar pedido
                </button>
            </div>
        </div>
    </div>
</div>
