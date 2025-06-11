<x-layouts.base metaTitle="Mapa del sitio web" tituloSeccion="Mapa del sitio web">

    <div class="card shadow-sm h-100 mb-3" aria-label="Mapa del sitio web completo" title="Mapa de navegación del sitio">
        <div class="card-body d-flex flex-column justify-content-between p-5">
            <p class="mb-4" style="font-size: 1.1rem">
                Aquí encontrarás un resumen completo de todas las páginas disponibles en nuestro sitio web.
            </p>

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Páginas públicas</h3>
            <ul class="list-unstyled ps-3">
                <li><a href="{{ route('user.index') }}" title="Ir a la página de inicio" aria-label="Inicio">Inicio</a>
                </li>
                <li><a href="{{ route('user.tienda') }}" title="Ver todos los productos" aria-label="Tienda">Tienda</a>
                </li>
                <li><a href="{{ route('user.aboutUs') }}" title="Más información sobre nosotros"
                        aria-label="Sobre nosotros">Sobre nosotros</a></li>
                <li><a href="{{ route('contact') }}" title="Formulario de contacto" aria-label="Contacto">Contacto</a>
                </li>
                <li><a href="{{ route('legalNotice') }}" title="Aviso legal y privacidad" aria-label="Aviso legal">Aviso
                        legal</a></li>
                <li><a href="{{ route('accessibility') }}" title="Información sobre accesibilidad"
                        aria-label="Accesibilidad">Accesibilidad</a></li>
                <li><a href="{{ route('siteMap') }}" title="Página actual: mapa web" aria-label="Mapa web">Mapa web</a>
                </li>
            </ul>

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Páginas de autenticación</h3>
            <ul class="list-unstyled ps-3">
                <li><a href="{{ route('login') }}" title="Iniciar sesión" aria-label="Login">Login</a></li>
                <li><a href="{{ route('register') }}" title="Crear una cuenta" aria-label="Registrarse">Registrarse</a>
                </li>
                <li><a href="{{ route('password.request') }}" title="Recuperar contraseña"
                        aria-label="Olvidé mi contraseña">Olvidé mi contraseña</a></li>
                <li><a href="{{ route('password.reset', ['token' => 'token']) }}" title="Restablecer contraseña"
                        aria-label="Restablecer contraseña">Restablecer contraseña</a></li>
                <li><a href="{{ route('verification.notice') }}" title="Verificar correo"
                        aria-label="Verificación de email">Verificación de email</a></li>
                <li><a href="{{ route('password.confirm') }}" title="Confirmar contraseña"
                        aria-label="Confirmar contraseña">Confirmar contraseña</a></li>
                <li><a href="{{ route('2fa') }}" title="Verificación en dos pasos" aria-label="2FA">2FA</a></li>
            </ul>

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Páginas para usuario autenticado</h3>
            <ul class="list-unstyled ps-3">
                <li aria-label="Carrito de compras">
                    <a href="{{ route('user.cart') }}" title="Ver carrito de compras" aria-label="Carrito">Carrito</a>
                </li>

                <li aria-label="Confirmación de pedido">
                    <a href="{{ route('user.orderConfirmation') }}" title="Ver confirmación de pedido" aria-label="Confirmación de pedido">Confirmación de pedido</a>
                </li>
            </ul>

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Zona de usuario</h3>
            <ul class="list-unstyled ps-3">
                <li><a href="{{ route('user.profile') }}" title="Ver perfil de usuario" aria-label="Perfil">Perfil</a>
                </li>
                <li><a href="{{ route('user.orders') }}" title="Historial de pedidos" aria-label="Pedidos">Pedidos</a>
                </li>
            </ul>


            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Zona de administración</h3>
            <ul class="list-unstyled ps-3">
                <li><a href="{{ route('admin.dashboard') }}" title="Dashboard de administrador"
                        aria-label="Dashboard admin">Dashboard</a></li>
                <li><a href="{{ route('admin.product') }}" title="Gestión de productos"
                        aria-label="Admin productos">Productos</a></li>
                <li><a href="{{ route('admin.order') }}" title="Gestión de pedidos"
                        aria-label="Admin pedidos">Pedidos</a></li>
                <li><a href="{{ route('admin.users') }}" title="Gestión de usuarios"
                        aria-label="Admin usuarios">Usuarios</a></li>
            </ul>

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Configuración de perfil</h3>
            <ul class="list-unstyled ps-3">
                <li><a href="{{ route('settings.profile') }}" title="Configuración de perfil"
                        aria-label="Configuración perfil">Perfil</a></li>
                <li><a href="{{ route('settings.password') }}" title="Cambiar contraseña"
                        aria-label="Configuración contraseña">Contraseña</a></li>
                <li><a href="{{ route('settings.appearance') }}" title="Cambiar apariencia"
                        aria-label="Configuración apariencia">Apariencia</a></li>
            </ul>

            <p class="mt-5 text-end">Última actualización: {{ date('d/m/Y') }}</p>
        </div>
    </div>

</x-layouts.base>
