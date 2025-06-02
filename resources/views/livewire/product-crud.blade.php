<div>
    @if ($view === 'list')
        <h2 class="mb-5 my-4 text-center">Ver datos de los Productos</h2>

        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong>Filtrar Productos</strong>

            </div>
            <div class="card-body">
                <form wire:submit.prevent="filter" class="row g-3 align-items-end">
                    <div class="col-md">
                        <label class="form-label">Nombre</label>
                        <input type="text" wire:model="name" placeholder="Buscar por nombre" class="form-control">
                    </div>

                    <div class="col-md">
                        <label class="form-label">ID</label>
                        <input type="number" wire:model="product_id" placeholder="Buscar por ID" class="form-control">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filtrar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" wire:click="resetFilters" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Borrar Filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>


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

        <div style="overflow-x: auto;">
            <div class="w-100 d-flex justify-content-between mb-3 align-items-center flex-wrap gap-2">
                <button wire:click="showCreateForm" class="btn btn-success">Crear nuevo producto</button>

                <!-- NO funciona (No está implementado es de decoración 😉 )-->
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
                        <th>Características</th>
                        <th>Tallas</th>
                        <th>Stock</th>
                        <th>Rebaja</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <p>Categoría: {{ $product->category }}</p>
                                <p>Color: {{ $product->color }}</p>
                                <p>Género: {{ $product->gender }}</p>
                                <p>Estilo: {{ $product->style }}</p>
                            </td>
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
                            @if ($product->discount <= 0)
                                <td>No tiene rebaja</td>
                            @else
                                <td>{{ $product->discount }}%</td>
                            @endif
                            <td>
                                @if ($product->discount > 0)
                                    <span style="text-decoration: line-through; color: gray;">
                                        {{ number_format($product->price, 2) }}€
                                    </span>
                                    <span style="color: red; font-weight: bold;">
                                        {{ number_format($product->price - ($product->price * $product->discount) / 100, 2) }}€
                                    </span>
                                @else
                                    {{ number_format($product->price, 2) }}€
                                @endif
                            </td>
                            <td>
                                <button wire:click="edit({{ $product->id }})" class="btn btn-warning btn-sm mt-2">
                                    <i class="bi bi-pencil"></i></button>
                                <button wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm mt-2"
                                    onclick="confirm('¿Estás seguro de eliminar este producto?') || event.stopImmediatePropagation()">
                                    <i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay Productos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <h2 class="mb-5 my-4 text-center"> {{ $product_id ? 'Actualizar' : 'Crear' }} Productos</h2>
        <div class="card p-3">

            <form wire:submit.prevent="{{ $product_id ? 'update' : 'store' }}" class="row g-3"
                enctype="multipart/form-data">
                <div class="col-md-12">
                    <label for="images" class="form-label">Imágenes</label>
                    @if ($imagesDB->count() > 0)
                        <div class="col-md-6 d-flex flex-wrap gap-3">
                            @foreach ($imagesDB as $index => $image)
                                <div style="position: relative; width: 150px; height: 150px;">
                                    <!-- Imagen -->
                                    <img src="{{ asset('storage/' . $image->url) }}" alt="Imagen"
                                        class="rounded w-100 h-100" style="object-fit: cover;">

                                    <!-- Botón de ampliar -->
                                    <button type="button" class="btn btn-sm btn-dark position-absolute top-0 end-0 m-1"
                                        style="background-color: rgba(0, 0, 0, 0.5); border: none;"
                                        data-bs-toggle="modal" data-bs-target="#imageModal{{ $index }}"
                                        title="Ver en grande">
                                        <i class="bi bi-fullscreen text-light"></i>
                                    </button>

                                    <!-- Botón de eliminar -->
                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-1"
                                        style="background-color: rgba(0, 0, 0, 0.5); border: none;"
                                        wire:click="deleteImage({{ $image->id }})" title="Eliminar imagen">
                                        <i class="bi bi-trash text-light"></i>
                                    </button>
                                </div>

                                <!-- Modal de imagen grande -->
                                <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <img src="{{ asset('storage/' . $image->url) }}" alt="Imagen ampliada"
                                                    class="img-fluid w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="col-md-12 d-flex align-items-center mt-3 gap-2">
                        <input type="file" wire:model="images" id="images" class="form-control form-control-sm"
                            multiple>
                        <button type="button" wire:click="uploadImages" class="btn btn-primary btn-sm">Aceptar</button>
                    </div>


                    @error('images.*')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" id="name" wire:model="name" class="form-control form-control-sm"
                        placeholder="Nombre">
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Descripción</label>
                    <input type="text" id="description" wire:model="description"
                        class="form-control form-control-sm" placeholder="Descripción">
                </div>

                <div class="col-md-6">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" id="color" wire:model="color" class="form-control form-control-sm"
                        placeholder="Color">
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Género</label>
                    <input type="text" id="gender" wire:model="gender" class="form-control form-control-sm"
                        placeholder="Género">
                </div>

                <div class="col-md-6">
                    <label for="style" class="form-label">Estilo</label>
                    <input type="text" id="style" wire:model="style" class="form-control form-control-sm"
                        placeholder="Estilo">
                </div>

                <div class="col-md-6 row mt-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Precio</label>
                        <input type="number" id="price" wire:model="price" class="form-control form-control-sm"
                            placeholder="Precio" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label for="discount" class="form-label">Descuento</label>
                        <input type="number" id="discount" wire:model="discount"
                            class="form-control form-control-sm" placeholder="Descuento" step="5"
                            max="90" min="0">
                    </div>
                </div>


                <div class="col-md-6">
                    <label for="category" class="form-label">Categoría</label>
                    <select id="category" wire:model="category" wire:change="filterSizes"
                        class="form-select form-select-sm">
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="newCategory" class="form-label">Otra categoría:</label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="newCategory" wire:model="newCategory" class="form-control"
                            placeholder="Nueva Categoría">
                        <button class="btn btn-outline-dark" type="button" wire:click="addNewCategory">
                            Añadir
                        </button>
                    </div>
                </div>

                <div class="col-12">
                    <h5 class="my-4">Asignar Stock por Talla</h5>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($availableSizes as $size)
                            <div class="d-flex align-items-center mb-2">
                                <label for="size-{{ $size->id }}" class="form-label mb-0 me-2"
                                    style="min-width: fit-content;">{{ $size->name }}</label>
                                <input type="number" id="size-{{ $size->id }}"
                                    wire:model="sizes.{{ $size->id }}" class="form-control form-control-sm me-4"
                                    placeholder="Stock" min="0" style="width: 80px;">
                            </div>
                        @endforeach
                        <div class="d-flex align-items-center mb-2">
                            <label for="newSize" class="form-label mb-0 me-2" style="min-width: fit-content;">Otra
                                talla:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="newSize" wire:model="newSize"
                                    class="form-control form-control-sm" placeholder="Ej: XS, M, XL...">
                                <button class="btn btn-outline-dark" type="button" wire:click="addNewSize">
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ $product_id ? 'Actualizar' : 'Crear' }}
                    </button>
                    <button type="button" wire:click="cancel" class="btn btn-secondary btn-sm">Cancelar</button>
                </div>
            </form>
        </div>
    @endif

</div>
