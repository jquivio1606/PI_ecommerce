<div class="row">

    <div class="col-md-6 mb-4">
        <!-- Imagen del producto -->
        <img src="producto1.jpg" alt="Producto 1" class="img-fluid" />
    </div>

    <div class="col-md-6">
        <h3>{{ $product->name }}</h3>
        <p class="text-muted">Categoría: {{ $product->category }} / {{ $product->gender }}</p>

        <!-- Descripción larga -->
        <p> {{ $product->description }} </p>

        <!-- Precio -->
        <p class="fw-bold fs-5"> {{ $product->price }} € </p>

        <livewire:add-to-cart :product="$product" />
    </div>
</div>
