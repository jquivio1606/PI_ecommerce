<div>
    <h2 class="mb-5 my-4 text-center">Ver Pedidos</h2>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>Filtrar Pedidos</strong>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="filter" aria-label="Formulario de filtro de pedidos">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Estado</label>
                        <select id="statusFilter" name="statusFilter" class="form-select" wire:model.defer="statusFilter" title="Filtrar por estado" aria-label="Filtrar por estado">
                            <option value="">-- Todos --</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            <option value="enviado">Enviado</option>
                            <option value="cancelado">Cancelado</option>
                            <option value="reembolsado">Reembolsado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="userName" class="form-label">Nombre de Usuario</label>
                        <input type="text" id="userName" name="userName" class="form-control" wire:model.defer="userName"
                            placeholder="Ej: Juan Pérez" title="Filtrar por nombre de usuario" aria-label="Nombre de Usuario">
                    </div>
                    <div class="col-md-3">
                        <label for="startDate" class="form-label">Desde</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" wire:model.defer="startDate"
                            title="Fecha de inicio" aria-label="Fecha de inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="endDate" class="form-label">Hasta</label>
                        <input type="date" id="endDate" name="endDate" class="form-control" wire:model.defer="endDate"
                            min="{{ $startDate }}" title="Fecha final" aria-label="Fecha final">
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary me-2" aria-label="Filtrar pedidos">
                            <i class="bi bi-search"></i> Filtrar
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="resetFilters" aria-label="Borrar filtros">
                            <i class="bi bi-x-circle"></i> Borrar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($showMessage)
        <div class="alert alert-{{ $messageType === 'success' ? 'success' : ($messageType === 'warning' ? 'warning' : 'danger') }} mb-4" role="alert">
            {{ $message }}
        </div>
    @endif

    @foreach ($orders as $order)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-light">
                <div>
                    <strong>Pedido #{{ $order->id }}</strong> - {{ $order->user->name }}
                    <span class="ms-3">Total: <strong>€{{ number_format($order->total, 2) }}</strong></span>
                </div>
                <div>
                    <label for="status-{{ $order->id }}" class="me-2 fw-bold">Estado:</label>
                    <select id="status-{{ $order->id }}" name="status-{{ $order->id }}" class="form-select form-select-sm d-inline-block w-auto"
                        wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                        title="Cambiar estado del pedido #{{ $order->id }}" aria-label="Estado del pedido {{ $order->id }}">
                        <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ $order->status === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="enviado" {{ $order->status === 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="cancelado" {{ $order->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="reembolsado" {{ $order->status === 'reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                </div>
            </div>

            <div class="card-body">
                @foreach ($order->items as $item)
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-md-3">
                            <h3 class="h6 mb-0" title="Nombre del producto">{{ $item->product->name }}</h3>
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted">Talla:</span> {{ $item->size->name }}
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted">Cantidad:</span> {{ $item->quantity }}
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted">Precio:</span> €{{ number_format($item->price, 2) }}
                        </div>
                        <div class="col-md-3 text-end">
                            <button class="btn btn-outline-danger btn-sm" wire:click="removeItem({{ $item->id }})"
                                title="Eliminar producto del pedido" aria-label="Eliminar producto {{ $item->product->name }}">
                                <i class="bi bi-trash3"></i> Eliminar Producto
                            </button>
                        </div>
                    </div>
                @endforeach

                @if (isset($totalreturn[$order->id]))
                    <div class="mt-2 d-flex justify-content-between">
                        <span><strong>Total a devolver:</strong> €{{ number_format($totalreturn[$order->id], 2) }}</span>
                        <button class="btn btn-warning btn-sm" wire:click="returned({{ $order->id }})"
                            title="Devolver dinero del pedido" aria-label="Devolver dinero del pedido {{ $order->id }}">
                            <i class="bi bi-coin"></i> Devolver dinero
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
