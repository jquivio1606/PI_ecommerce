<div id="producto-detalle">
    @if ($message)
        <div id="mensaje" class="alert alert-{{ $messageType == 'success' ? 'success' : 'danger' }} mb-4"
             role="alert" aria-label="Mensaje del sistema">
            {{ $message }}
        </div>
    @endif

    @if ($product)
        <p id="talla-encabezado" class="mt-3 mb-2 fw-bold" >Selecciona una talla:</p>
        <div id="tallas" class="d-flex flex-wrap gap-2" role="radiogroup" aria-label="Opciones de tallas disponibles">
            @foreach ($product->sizes as $size)
                <div class="form-check">
                    <input
                        class="form-check-input border border-dark focus-ring"
                        type="radio"
                        wire:model="sizeId"
                        id="size-{{ $size->id }}"
                        name="size"
                        value="{{ $size->id }}"
                        aria-label="Talla {{ strtoupper($size->name) }}"
                        title="Selecciona la talla {{ strtoupper($size->name) }}"
                    >
                    <label class="form-check-label" for="size-{{ $size->id }}">
                        {{ strtoupper($size->name) }}
                    </label>
                </div>
            @endforeach
        </div>

        <div id="seccion-cantidad" class="d-flex mt-3">
            <div class="d-flex flex-column flex-wrap w-100">
                <p id="cantidad-encabezado" class="mb-1 fw-bold">Cantidad:</p>
                <div class="d-flex gap-2 justify-content-between align-items-end">
                    <label for="cantidad" class="visually-hidden">Introduce la cantidad</label>
                    <input
                        type="number"
                        id="cantidad"
                        name="cantidad"
                        wire:model="quantity"
                        min="1"
                        class="form-control border border-dark"
                        aria-label="Campo para introducir la cantidad"
                        title="Introduce la cantidad"
                    />

                    <button
                        wire:click="addToCart"
                        id="boton-add-cart"
                        class="btn btn-primary form-control"
                        {{ auth()->check() ? '' : 'disabled' }}
                        aria-label="Añadir al carrito"
                        title="Añadir al carrito"
                    >
                        <i class="bi bi-cart-plus" aria-hidden="true"></i>
                        Añadir al carrito
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning" role="alert" aria-label="Producto no disponible">
            Producto no disponible.
        </div>
    @endif

    @if (!auth()->check())
        <div id="alerta-login" class="d-flex justify-content-end mt-2">
            <div class="fw-bold alert alert-warning"
                style="font-size: x-small; color: black"
                role="alert"
                aria-label="Debes iniciar sesión para añadir productos al carrito"
                title="Debes iniciar sesión para añadir productos al carrito"
            >
                *Inicia sesión para poder añadir productos al carrito.
            </div>
        </div>
    @endif
</div>
