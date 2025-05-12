<div class="container my-4">

    @if ($showMessage)
        <div
            class="alert alert-{{ $messageType == 'success' ? 'success' : ($messageType == 'warning' ? 'warning' : 'danger') }} mb-4">
            {{ $message }}
        </div>
    @endif


    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>Filtrar Pedidos</strong>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="filter">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" wire:model.defer="statusFilter">
                            <option value="">-- Todos --</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            <option value="enviado">Enviado</option>
                            <option value="cancelado">Cancelado</option>
                            <option value="reembolsado">Reembolsado</option>
                        </select>
                    </div>
                     <div class="col-md-3">
                        <label class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" wire:model.defer="userName" placeholder="Ej: Juan Pérez">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Desde</label>
                        <input type="date" class="form-control" wire:model.defer="startDate" id="startDate">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Hasta</label>
                        <input type="date" class="form-control" wire:model.defer="endDate" min="{{ $startDate }}" id="endDate">
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="resetFilters">
                            <i class="bi bi-x-circle"></i> Limpiar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @foreach ($orders as $order)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-light">
                <div>
                    <strong>Pedido #{{ $order->id }}</strong> - {{ $order->user->name }}
                    <span class="ms-3">Total: <strong>€{{ number_format($order->total, 2) }}</strong></span>
                </div>
                <div>
                    <label for="status-{{ $order->id }}" class="me-2 fw-bold">Estado:</label>
                    <select id="status-{{ $order->id }}" class="form-select form-select-sm d-inline-block w-auto"
                        wire:change="updateStatus({{ $order->id }}, $event.target.value)">
                        <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente
                        </option>
                        <option value="pagado" {{ $order->status === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="enviado" {{ $order->status === 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="cancelado" {{ $order->status === 'cancelado' ? 'selected' : '' }}>Cancelado
                        </option>
                        <option value="reembolsado" {{ $order->status === 'reembolsado' ? 'selected' : '' }}>Reembolsado
                        </option>
                    </select>
                </div>
            </div>

            <div class="card-body">
                @foreach ($order->items as $item)
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-md-3">
                            <h6 class="mb-0">{{ $item->product->name }}</h6>
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
                            <button class="btn btn-outline-danger btn-sm" wire:click="removeItem({{ $item->id }})">
                                <i class="bi bi-trash3"></i> Eliminar Producto
                            </button>
                        </div>
                    </div>
                @endforeach
                @if (isset($totalreturn[$order->id]))
                    <div class="mt-2 d-flex justify-content-between">
                        <span><strong>Total a devolver: </strong>€{{ number_format($totalreturn[$order->id], 2) }}</span>
                        <button class="btn btn-warning btn-sm" wire:click="returned({{ $order->id }})">
                            <i class="bi bi-coin"></i> Devolver dinero
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
