<x-layouts.base metaTitle="Contacto" tituloSeccion="Contacto">
    <div class="card shadow-sm h-100 mb-5" aria-label="Información de contacto" title="Información de contacto">
        <div class="card-body d-flex flex-column justify-content-between p-5">
            <p class="mb-2" style="font-size: 1.1rem">
                Si tienes alguna duda, sugerencia o necesitas más información, no dudes en ponerte en contacto
                con nosotros.
            </p>
            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Datos de contacto</h3>
            <ul class="list-unstyled ps-3">
                <li><strong>Nombre comercial:</strong> TuTiendaRopa</li>
                <li><strong>Correo electrónico:</strong> <a class="text-primary"
                        href="mailto:contacto@tutiendaropa.com">contacto@tutiendaropa.com</a></li>
                <li><strong>Teléfono:</strong> +34 123 456 789</li>
                <li><strong>Horario de atención:</strong> Lunes a viernes, de 9:00 a 18:00</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm h-100" aria-label="Formulario de Contacto" title="Formulario de contacto">
        <div class="card-body d-flex flex-column justify-content-between p-5">
            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Formulario de contacto</h3>
            <form>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="correo" placeholder="tucorreo@ejemplo.com">
                </div>
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" rows="4" placeholder="Escribe tu mensaje aquí..."></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Enviar</button>
            </form>

            <p class="mt-5 text-end">Última actualización: {{ date('d/m/Y') }}</p>
        </div>
    </div>
</x-layouts.base>
