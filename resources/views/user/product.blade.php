<x-layouts.base metaTitle="Detalles del Producto" tituloSeccion="Detalles del Producto">

    @livewire('product-show', ['id' => $product->id])

    <!-- Sección de comentarios -->
    <div class="mt-5">
        <h3>Comentarios sobre el producto</h3>

        <form action="enviar_comentario.php" method="POST">
            <!-- Formulario de comentario -->
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario:</label>
                <textarea id="comentario" name="comentario" class="form-control" rows="4"
                    placeholder="Deja tu comentario sobre este producto" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-2">
                <i class="bi bi-chat-dots"></i> Enviar Comentario
            </button>
        </form>


        <!-- Lista de comentarios (ejemplo) -->
        <div class="mt-4">
            <h4>Comentarios recientes</h4>

            <div class="border p-3 mb-3">
                <p><strong>Juan Pérez:</strong> Me encantó esta camiseta, el material es súper cómodo y la talla me
                    quedó
                    perfecta. La recomiendo mucho.</p>
            </div>

            <div class="border p-3 mb-3">
                <p><strong>Ana González:</strong> El color es igual al de la foto, pero la talla me quedó un poco
                    grande.
                    Deberían ofrecer más opciones de talla.</p>
            </div>
        </div>
    </div>
</x-layouts.base>
