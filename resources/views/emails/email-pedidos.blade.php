<h2>¡Nuevo pedido recibido!</h2>
<p>El usuario <strong>{{ $usuario->name }}</strong> ({{ $usuario->email }}) ha realizado un pedido.</p>

<p><strong>ID del pedido:</strong> {{ $pedido->id }}</p>
<p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

<p>
    <a href="{{ url('/admin/pedidos/') }}"
        style="padding:10px 15px; background:#0d6efd; color:white; text-decoration:none; border-radius:5px;">
        Ver en la web
    </a>
</p>
