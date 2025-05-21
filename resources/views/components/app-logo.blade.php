<div class="ms-1 grid flex-1 text-start text-sm">
    @if(Auth::check() && Auth::user()->role == 0)
        <span class="text-dark text-decoration-none mb-0.5 fs-5 truncate leading-none font-semibold" style="text-de: none">Perfil de usuario</span>
    @else
        <span class="text-dark text-decoration-none mb-0.5 fs-5 truncate leading-none font-semibold" style="text-de: none">Menú de administrador</span>
    @endif
</div>
