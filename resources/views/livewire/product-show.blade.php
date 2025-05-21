<div class="row">

    <div class="col-md-6 mb-4">
        <!-- Imagen del producto -->
        <img src="producto1.jpg"
            alt="Imagen de {{ $product->name }} - {{ $product->category }}, para {{ $product->gender }}"
            aria-label="Imagen del producto {{ $product->name }}" title="Imagen del producto {{ $product->name }}"
            class="img-fluid" />
    </div>

    <div class="col-md-6">
        <h3>{{ $product->name }}</h3>
        <p class="text-muted">Categoría: {{ $product->category }} / {{ $product->gender }}</p>

        <!-- Descripción larga -->
        <p> {{ $product->description }} </p>

        <!-- Precio -->
        @if ($product->discount > 0)
            <p>
                <span class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }}€</span>
                <span
                    class="fw-bold fs-5 text-danger ms-2">{{ number_format($product->price - ($product->price * $product->discount) / 100, 2) }}€</span>
            </p>
        @else
            <p class="fw-bold fs-5">{{ number_format($product->price, 2) }}€</p>
        @endif

        <livewire:add-to-cart :product="$product" />
    </div>
</div>
