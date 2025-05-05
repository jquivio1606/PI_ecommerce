<div>


    @if ($message)
        <div class="alert alert-{{ $messageType == 'success' ? 'success' : 'danger' }} mb-4">
            {{ $message }}
        </div>
    @endif


    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('productos.show', $product->id) }}" class="btn btn-outline-primary flex-grow-1">Ver Producto</a>

        @if ($product)
            <select wire:model="sizeId" class="form-select mb-2">
                <option value="">Selecciona una talla</option>
                @foreach ($product->sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>

            <input type="number" wire:model="quantity" min="1" class="form-control mb-2" />

            <button wire:click="addToCart" class="btn btn-primary" {{ auth()->check() ? '' : 'disabled' }}><i
                    class="bi bi-cart-plus"></i></button>
        @else
            <div class="alert alert-warning">Producto no disponible.</div>
        @endif
    </div>

    @if (!auth()->check())
    <div style="display: flex; justify-content: flex-end;">
        <div style=" font-size: x-small; font-weight: bold; background-color: rgb(255, 233, 171); border-radius: 10px; padding: 5px 10px;">
            *Inicia sesión para poder añadir productos al carrito.
        </div>
    </div>
    @endif
</div>
