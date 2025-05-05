<div>

    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif


    @if ($view === 'list')
        <form wire:submit.prevent="filter" class="d-flex justify-content-between mb-3 gap-3">
            <input type="text" wire:model="name" placeholder="Buscar por nombre" class="form-control form-control-sm" />
            <input type="number" wire:model="product_id" placeholder="Buscar por ID"
                class="form-control form-control-sm" />
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <div style="width: 100%; overflow-x: auto;">
            <div class="d-flex justify-content-between mb-3 align-items-center flex-wrap gap-2">
                <button wire:click="showCreateForm" class="btn btn-primary">Crear nuevo producto</button>

                <!--Todavía NO funciona-->
                <div>
                    <select class="form-select form-select-sm">
                        <option value="5">Mostrar 5 primeros productos</option>
                        <option value="10">Mostrar 10 primeros productos</option>
                        <option value="20">Mostrar 20 primeros productos</option>
                        <option value="50">Mostrar 50 primeros productos</option>
                    </select>
                </div>
            </div>
            <table class="table table-bordered table-striped w-100 align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Color</th>
                        <th>Género</th>
                        <th>Estilo</th>
                        <th>Tallas</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($filters)
                        @if ($prodFiltrado && count($prodFiltrado) > 0)
                            @foreach ($prodFiltrado as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->color }}</td>
                                    <td>{{ $product->gender }}</td>
                                    <td>{{ $product->style }}</td>
                                    <td>
                                        @foreach ($product->sizes as $size)
                                            <div>{{ $size->name }}</div>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($product->sizes as $size)
                                            <div>{{ $size->pivot->stock }}</div>
                                        @endforeach
                                    </td>
                                    <td>{{ $product->category }}</td>
                                    <td>{{ $product->price }}€</td>
                                    <td>
                                        <button wire:click="edit({{ $product->id }})"
                                            class="btn btn-warning btn-sm mt-2"><i class="bi bi-pencil"></i></button>
                                        <button wire:click="delete({{ $product->id }})"
                                            class="btn btn-danger btn-sm mt-2"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            <button type="button" wire:click="resetFilters" class="btn btn-secondary my-3">Mostrar
                                todos</button>

                        @endif
                    @else
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->color }}</td>
                                <td>{{ $product->gender }}</td>
                                <td>{{ $product->style }}</td>
                                <td>
                                    @foreach ($product->sizes as $size)
                                        <div>{{ $size->name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($product->sizes as $size)
                                        <div>{{ $size->pivot->stock }}</div>
                                    @endforeach
                                </td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->price }}€</td>
                                <td>
                                    <button wire:click="edit({{ $product->id }})"
                                        class="btn btn-warning btn-sm mt-2"><i class="bi bi-pencil"></i></button>
                                    <button wire:click="delete({{ $product->id }})"
                                        class="btn btn-danger btn-sm mt-2"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    @else
        <form wire:submit.prevent="{{ $product_id ? 'update' : 'store' }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" wire:model="name" placeholder="Nombre" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
                <input type="text" wire:model="description" placeholder="Descripción"
                    class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
                <input type="text" wire:model="color" placeholder="Color" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
                <input type="text" wire:model="gender" placeholder="Género" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
                <input type="text" wire:model="style" placeholder="Estilo" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
                <input type="text" wire:model="category" placeholder="Categoría"
                    class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
                <input type="number" wire:model="price" placeholder="Precio" step="0.01"
                    class="form-control form-control-sm">
            </div>

            <div class="col-12">
                <h5 class="mb-2">Asignar Stock por Talla</h5>
                @foreach ($availableSizes as $size)
                    <div class="mb-2 d-flex align-items-center">
                        <label class="me-2">{{ $size->name }}</label>
                        <input type="number" wire:model="sizes.{{ $size->id }}"
                            class="form-control form-control-sm" placeholder="Stock para esta talla" min="0">
                    </div>
                @endforeach
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    {{ $product_id ? 'Actualizar' : 'Crear' }}
                </button>
                <button type="button" wire:click="cancel" class="btn btn-secondary btn-sm">Cancelar</button>
            </div>
        </form>
    @endif

</div>
