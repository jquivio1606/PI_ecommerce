<x-layouts.base metaTitle="Carrito" tituloSeccion="Mi cesta de Compra">
    <!-- Cesta de compras -->
    <div class="row">
        <!-- Tarjeta de producto en la cesta -->
        <div class="col-12 mb-3">
            <div class="card p-3">
                <div class="row align-items-center">
                    <!-- Check box -->
                    <div class="col-auto">
                        <input type="checkbox" id="producto1" class="form-check-input" />
                    </div>

                    <!-- Imagen del producto -->
                    <div class="col-3">
                        <img src="" alt="Nombre Producto" class="img-fluid" />
                    </div>

                    <!-- Descripción del producto -->
                    <div class="col">
                        <h5>Producto de Ropa</h5>
                        <p class="text-muted">Descripción breve del producto de ropa, materiales, etc.</p>
                        <p class="text-muted">Talla: X</p>
                        <p>Precio: <span class="fw-bold">€19.99</span></p>
                    </div>

                    <!-- Botones: Ver producto y Eliminar producto -->
                    <div class="col-auto">
                        <a href="{{ route('user.product') }}" class="btn btn-outline-primary mb-2">
                            <i class="bi bi-eye"></i> Ver Producto
                        </a>
                        <br />
                        <a href="{{ route('user.product') }}" class="btn btn-outline-danger">
                            <i class="bi bi-cart-dash"></i> Eliminar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aquí puedes añadir más tarjetas de productos de la cesta -->
    </div>

    <!-- Total y botones finales (si lo deseas) -->
    <div class="d-flex justify-content-between mt-4">
        <h4>Total: €19.99</h4>
        <button class="btn btn-success">Ir a Pagar</button>
    </div>
    </div>
</x-estructura.base>
