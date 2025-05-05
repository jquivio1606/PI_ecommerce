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

        <form action="agregar_al_carrito.php" method="POST">
            <!-- Apartado para elegir talla -->
            <div class="mb-3">
                <label for="talla" class="form-label">Talla:</label>
                <select class="form-select" id="talla" name="talla" required>
                    <option value="" selected disabled>
                        {{ $product->size === null ? 'Elige una talla' : $product->size }}</option>
                    @foreach ($product->sizes as $size)
                        <option value="{{ $size->name }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botón de agregar al carrito -->
            <button type="submit" class="btn btn-success w-100">

            </button>
        </form>
    </div>
</div>
