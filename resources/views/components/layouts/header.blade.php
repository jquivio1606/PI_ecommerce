<!-- Header -->
<header class="bg-light py-2 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Izquierda: logo + nombre -->
        <div class="d-flex align-items-center">
            <img src="" alt="logo" class="me-2 rounded-circle" />
            <h4 class="mb-0">Nombre Tienda</h4>
        </div>
        <!-- Derecha: login / registro -->
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="mx-3 text-decoration-none text-dark">
                        Perfil
                    </a>
                @else
                    <a href="{{ route('login') }}" class="mx-3 text-decoration-none text-dark">
                        Iniciar sesión
                    </a> |

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mx-3 text-decoration-none text-dark">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</header>
