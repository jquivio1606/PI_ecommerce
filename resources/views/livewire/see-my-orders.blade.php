<div class="container mt-4">
    @if ($orders->count())
        @foreach ($orders as $order)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Pedido #{{ $order->id }}</strong> |
                    Fecha: {{ $order->created_at->format('d/m/Y') }} |
                    Estado: <span class="badge bg-info">{{ $order->status }}</span>
                </div>
                <div class="card-body">
                    @foreach ($order->items as $item)
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" class="img-fluid">
                            </div>
                            <div class="col-md-10">
                                <h5>{{ $item->product->name }}</h5>
                                <p>{{ $item->product->description }}</p>
                                <p>
                                    <strong>Cantidad:</strong> {{ $item->quantity }} |
                                    <strong>Precio:</strong> ${{ $item->price }} |
                                    <strong>Talla:</strong> {{ $item->size->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="text-end">
                        <strong>Total:</strong> ${{ $order->total }}
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            Aún no tienes pedidos realizados.
        </div>
    @endif
</div>
