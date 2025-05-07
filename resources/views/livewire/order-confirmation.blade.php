<div x-data x-on:orderConfirmed.window="alert('¡Pedido confirmado!')">
    <div class="row">
        @foreach ($cartItems as $item)
            <div class="col-12 mb-3">
                <div class="card p-3">
                    <div class="row">
                        <!-- Columna para la imagen del producto -->
                        <div class="col-md-4 col-12 my-3">
                            <img src="{{ $item->product->image }}" class="img-fluid" alt="{{ $item->product->name }}">
                        </div>

                        <!-- Columna para los datos del producto -->
                        <div class="col-md-8 col-12">
                            <h5 class="mt-3">{{ $item->product->name }}</h5>
                            <p class="text-muted">{{ $item->product->description }}</p>

                            <div class="row flex-wrap">
                                <!-- Detalles del producto (Género, Estilo, Categoría, Color) -->
                                <div class="col-6 col-md-4">
                                    <p><strong>Género:</strong> {{ $item->product->gender }}</p>
                                    <p><strong>Estilo:</strong> {{ $item->product->style }}</p>
                                    <p><strong>Categoría:</strong> {{ $item->product->category }}</p>
                                    <p><strong>Color:</strong> {{ $item->product->color }}</p>
                                </div>

                                <!-- Detalles adicionales (Talla, Cantidad, Precio, Total) -->
                                <div class="col-6 col-md-4">
                                    <p><strong>Talla:</strong>
                                        {{ $item->product->sizes->firstWhere('id', $item->size_id)->name }}</p>
                                    <p><strong>Cantidad:</strong> {{ $item->quantity }}</p>
                                    <p><strong>Precio Unidad:</strong> {{ number_format($item->product->price, 2) }} €
                                    </p>
                                    <p><strong>Total:</strong>
                                        {{ number_format($item->product->price * $item->quantity, 2) }} €</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="text-center my-4">
        <p class="fw-bold fs-4">Total a pagar: {{ number_format($totalPrice, 2) }} €</p>
    </div>

    <div class="d-flex justify-content-between align-items-center my-5">
        <div class="row w-100">
            <!-- Selección de método de pago (Columna 1) -->
            <!-- Método de pago (Label y Select en una fila) -->
            <div class="col-md-6 col-12 mb-3 d-flex align-items-center">
                <label for="paymentMethod" class="w-25 fw-bold">Método de pago:</label>
                <select class="form-control" id="paymentMethod">
                    <option value="creditCard">Tarjeta de Crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="bankTransfer">Transferencia Bancaria</option>
                </select>
            </div>

            <!-- Botones Confirmar y Pagar + Cancelar (Columna 2) -->
            <div class="col-md-6 col-12 mb-3 d-flex justify-content-end gap-4">
                <button class="btn btn-success" wire:click="confirmOrder">
                    <i class="bi bi-credit-card"></i> Confirmar y pagar
                </button>
                <button class="btn btn-danger" wire:click="cancelOrder">
                    <i class="bi bi-x-square"></i> Cancelar
                </button>
            </div>
        </div>
    </div>

</div>
