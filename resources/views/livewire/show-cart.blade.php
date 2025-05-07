<div>

    @if ($message)
        <div
            class="alert alert-{{ $messageType == 'success' ? 'success' : ($messageType == 'warning' ? 'warning' : 'danger') }} mb-4">
            {{ $message }}
        </div>
    @endif


    <div class="row">
        @foreach ($cartItems as $item)
            <div class="col-12 mb-3">
                <div class="card p-3">
                    <div class="row align-items-center">
                        <!-- Check box -->
                        <div class="col-auto">
                            <!-- Checkbox -->
                            <input type="checkbox" wire:click="itemSelection({{ $item->id }})"
                                {{ in_array($item->id, $selectedItems) ? 'checked' : '' }}>
                        </div>

                        <!-- Imagen del producto -->
                        <div class="col-3">
                            <img src="{{ $item->product->image }}" class="img-fluid" alt="{{ $item->product->name }}">
                        </div>

                        <!-- Descripción del producto -->
                        <div class="col">
                            <h5>{{ $item->product->name }}</h5>
                            <p class="text-muted">{{ $item->product->description }}</p>

                            <!-- Talla y Cantidad en dos columnas -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="size">Talla</label>
                                        <select wire:model="size" class="form-control" id="size"
                                            wire:change="updateCartItem({{ $item->id }}, {{ $item->quantity }}, $event.target.value)">
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
                                        <label for="quantity">Cantidad</label>
                                        <input type="number" wire:model="quantity" min="1" class="form-control"
                                            id="quantity" value="{{ $item->quantity }}"
                                            wire:change="updateCartItem({{ $item->id }}, $event.target.value, {{ $item->size_id }})">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="fs-6 text-decoration-underline fw-semibold"> Precio Unidad:
                                        {{ number_format($item->product->price, 2) }} €
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="fs-6 text-decoration-underline fw-semibold"> Precio Total:
                                        {{ number_format($item->product->price, 2) * $item->quantity }} €
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones: Ver producto y Eliminar producto -->
                        <div class="col-auto d-flex justify-content-around flex-column ">
                            <a href="{{ route('productos.show', $item->product->id) }}"
                                class="btn btn-outline-primary mb-2">
                                <i class="bi bi-eye"></i> Ver Producto
                            </a>
                            <a wire:click="confirmDeletion({{ $item->id }})" class="btn btn-danger mt-2">
                                <i class="bi bi-cart-dash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="fixed-bottom bg-light py-4">
            <div class="container d-flex gap-5 justify-content-end">
                <p class="text-right me-5">
                    <strong>Cantidad de productos seleccionados: {{ count($selectedItems) }}</strong>
                </p>
                <p class="text-right me-5">
                    <strong>Total: {{ number_format($totalPrice, 2) }} €</strong>
                </p>
                <button class="btn btn-primary" wire:click="makeOrder">
                    Hacer pedido
                </button>
            </div>
        </div>
    </div>
</div>
