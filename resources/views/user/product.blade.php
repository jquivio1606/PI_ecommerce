<x-layouts.base metaTitle="Detalles del Producto" tituloSeccion="Detalles del Producto">

    @livewire('product-show', ['id' => $product->id])

    <!-- Sección de comentarios -->
    <div class="mt-5" aria-label="Sección de comentarios sobre el producto" role="region" tabindex="-1">
        <h3 id="comentarios-title">Comentarios sobre el producto</h3>

        <form action="{{ route('productos.show', $product->id) }}"  aria-labelledby="comentarios-title" novalidate>
            <!-- Formulario de comentario -->
            <div class="mb-3">
                <label for="comentario" class="mt-2 form-label" id="comentario-label"
                    title="Etiqueta para el campo de comentario">
                    Comentario:
                </label>
                <textarea id="comentario" name="comentario" class="form-control" rows="4"
                    placeholder="Deja tu comentario sobre este producto" aria-describedby="comentario-desc" required
                    title="Área para escribir un comentario sobre el producto"></textarea>
                <div id="comentario-desc" class="form-text">Escribe aquí tu opinión sobre el producto.</div>
            </div>

            <button type="submit" class="btn btn-primary mt-2" aria-label="Enviar comentario sobre el producto"
                title="Enviar comentario">
                <i class="bi bi-chat-dots" aria-hidden="true"></i> Enviar Comentario
            </button>
        </form>

        <!-- Lista de comentarios (ejemplo) -->
        <div class="mt-4" aria-live="polite" aria-relevant="additions" aria-atomic="true" role="region"
            tabindex="-1">
            <h4>Comentarios recientes</h4>

            <div class="border p-3 mb-3" aria-label="Comentario de Juan Pérez">
                <p><strong>Juan Pérez:</strong> Me encantó esta camiseta, el material es súper cómodo y la talla me
                    quedó perfecta. La recomiendo mucho.</p>
            </div>

            <div class="border p-3 mb-3" aria-label="Comentario de Ana González">
                <p><strong>Ana González:</strong> El color es igual al de la foto, pero la talla me quedó un poco
                    grande. Deberían ofrecer más opciones de talla.</p>
            </div>
        </div>
    </div>
</x-layouts.base>
