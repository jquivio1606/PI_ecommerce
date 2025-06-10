<div>
    <div class="row">
        @foreach ($cartItems as $item)
            <div class="col-12 mb-3">
                <div class="card p-3" role="group" aria-label="{{ $item->product->name }}">
                    <div class="row">
                        <!-- Imagen del producto -->
                        <div class="col-md-4 col-12 my-3">
                            <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                alt="Imagen de {{ $item->product->name }} - {{ $item->product->category }}, para {{ $item->product->gender }}"
                                aria-label="Imagen del producto {{ $item->product->name }}"
                                title="Imagen del producto {{ $item->product->name }}"
                                class="img-fluid rounded shadow-sm d-block mx-auto" style="max-height: 250px;">
                        </div>

                        <!-- Datos del producto -->
                        <div class="col-md-8 col-12">
                            <h3 class="h5" title="Nombre del producto">{{ $item->product->name }}</h3>
                            <p class="text-muted" title="Descripción del producto">
                                {{ $item->product->description }}</p>

                            <div class="row flex-wrap">
                                <!-- Info básica -->
                                <div class="col-6 col-md-4" role="list"
                                    aria-label="Características básicas del producto">
                                    <p role="listitem"><strong>Género:</strong>
                                        <span>{{ $item->product->gender }}</span>
                                    </p>
                                    <p role="listitem"><strong>Estilo:</strong>
                                        <span>{{ $item->product->style }}</span>
                                    </p>
                                    <p role="listitem"><strong>Categoría:</strong>
                                        <span>{{ $item->product->category }}</span>
                                    </p>
                                    <p role="listitem"><strong>Color:</strong> <span>{{ $item->product->color }}</span>
                                    </p>
                                </div>

                                <!-- Talla, cantidad, precios -->
                                <div class="col-6 col-md-4" role="list"
                                    aria-label="Talla, cantidad y precios del producto">
                                    <p role="listitem">
                                        <strong>Talla:</strong>
                                        <span title="Talla seleccionada">
                                            {{ $item->product->sizes->firstWhere('id', $item->size_id)->name }}
                                        </span>
                                    </p>
                                    <p role="listitem">
                                        <strong>Cantidad:</strong>
                                        <span title="Cantidad seleccionada">{{ $item->quantity }}</span>
                                    </p>

                                    {{-- Precio unidad con o sin descuento --}}
                                    <p role="listitem">
                                        <strong>Precio Unidad:</strong>
                                        @if ($item->product->discount && $item->product->discount > 0)
                                            <span class="text-decoration-line-through text-secondary me-2"
                                                title="Precio original">
                                                {{ number_format($item->product->price, 2) }} €
                                            </span>
                                            <span class="text-danger fw-bold" title="Precio con descuento">
                                                {{ number_format($item->product->price - ($item->product->price * $item->product->discount) / 100, 2) }}
                                                €
                                            </span>
                                        @else
                                            {{ number_format($item->product->price, 2) }} €
                                        @endif
                                    </p>

                                    {{-- Total por producto --}}
                                    <p role="listitem">
                                        <strong>Total:</strong>
                                        @if ($item->product->discount && $item->product->discount > 0)
                                            {{ number_format(($item->product->price - ($item->product->price * $item->product->discount) / 100) * $item->quantity, 2) }}
                                            €
                                        @else
                                            {{ number_format($item->product->price * $item->quantity, 2) }} €
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Total general -->
    <div class="text-center my-4" role="contentinfo" aria-label="Total general a pagar">
        <p class="fw-bold fs-4">Total a pagar: {{ number_format($totalPrice, 2) }} €</p>
    </div>

    <!-- Métodos de pago y botones -->
    <div class="d-flex justify-content-between align-items-center my-5">
        <div class="row w-100">
            <div class="col-md-6 col-12 mb-3 d-flex align-items-center">
                <label for="paymentMethod" class="w-25 fw-bold" id="paymentMethodLabel">Método de pago:</label>
                <select class="form-control" id="paymentMethod" aria-labelledby="paymentMethodLabel"
                    title="Selecciona método de pago">
                    <option value="creditCard">Tarjeta de Crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="bankTransfer">Transferencia Bancaria</option>
                </select>
            </div>

            <div class="col-md-6 col-12 mb-3 d-flex justify-content-end gap-4">
                <button class="btn btn-success" wire:click="confirmOrder" aria-label="Confirmar y pagar pedido"
                    title="Confirmar y pagar pedido">
                    <i class="bi bi-credit-card" aria-hidden="true"></i> Confirmar y pagar
                </button>
                <button class="btn btn-danger" wire:click="cancelOrder" aria-label="Cancelar pedido"
                    title="Cancelar pedido">
                    <i class="bi bi-x-square" aria-hidden="true"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
