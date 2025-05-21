<!-- Header -->
<header class="bg-light py-2 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Izquierda: logo + nombre -->
        <div class="d-flex align-items-center gap-2">
            @include('components.app-logo-icon')
            <h1 class=" h4 mb-0">Nombre Tienda</h1>
        </div>
        <!-- Derecha: login / registro -->
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="mx-3 text-decoration-none text-dark" title="Ir al perfil" aria-label="Perfil de usuario">
                        <i class="bi bi-person-circle" aria-hidden="true"></i> Perfil
                    </a>
                @else
                    <a href="{{ route('login') }}" class="mx-3 text-decoration-none text-dark" title="Iniciar sesión" aria-label="Iniciar sesión">
                        Iniciar sesión
                    </a> |

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mx-3 text-decoration-none text-dark" title="Registrarse" aria-label="Registrarse">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</header>
