<div>
    @if ($message)
        <div class="alert alert-{{ $messageType == 'success' ? 'success' : 'danger' }} mb-4">
            {{ $message }}
        </div>
    @endif

    @if ($product)
        <div class="mb-2">
            <label class="form-label"><strong>Selecciona una talla:</strong></label>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($product->sizes as $size)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="sizeId" id="size-{{ $size->id }}"
                            value="{{ $size->id }}">
                        <label class="form-check-label" for="size-{{ $size->id }}">
                            {{ strtoupper($size->name) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex">
            <div class="d-flex flex-column flex-wrap w-100">
                <label for="cantidad">Cantidad:</label>
                <div  class="d-flex gap-2 justify-content-between">
                    <input type="number" name="cantidad" wire:model="quantity" min="1" class="form-control" />
                    <button wire:click="addToCart" class="btn btn-primary form-control" {{ auth()->check() ? '' : 'disabled' }}>
                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">Producto no disponible.</div>
    @endif

    @if (!auth()->check())
        <div style="display: flex; justify-content: flex-end;">
            <div
                style="font-size: x-small; font-weight: bold; background-color: rgba(0, 0, 0, 0.7); color: rgb(255, 197, 36); border-radius: 10px; padding: 5px 10px;">
                *Inicia sesión para poder añadir productos al carrito.
            </div>
        </div>
    @endif
</div>
