<div>
    @if ($view === 'list')
        <h2 class="mb-5 my-4 text-center" id="productos-heading">Ver datos de los Productos</h2>

        <div class="card mb-4" role="region" aria-labelledby="filtro-productos-label">
            <div class="card-header bg-light">
                <strong id="filtro-productos-label">Filtrar Productos</strong>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="filter" class="row g-3 align-items-end" aria-describedby="filtro-desc">
                    <div id="filtro-desc" class="visually-hidden">
                        Formulario para filtrar productos por nombre o ID.
                    </div>
                    <div class="col-md">
                        <label for="filter-name" class="form-label">Nombre</label>
                        <input type="text" wire:model="name" id="filter-name" placeholder="Buscar por nombre"
                            class="form-control" aria-describedby="filter-name-desc">
                        <small id="filter-name-desc" class="visually-hidden">Escribe el nombre para buscar</small>
                    </div>

                    <div class="col-md">
                        <label for="filter-id" class="form-label">ID</label>
                        <input type="number" wire:model="product_id" id="filter-id" placeholder="Buscar por ID"
                            class="form-control" aria-describedby="filter-id-desc">
                        <small id="filter-id-desc" class="visually-hidden">Escribe el ID del producto para
                            buscar</small>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" aria-label="Filtrar productos">
                            <i class="bi bi-search" title="Buscar"></i> Filtrar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" wire:click="resetFilters" class="btn btn-secondary"
                            aria-label="Borrar filtros">
                            <i class="bi bi-x-circle" title="Borrar filtros"></i> Borrar Filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div style="overflow-x: auto;" role="region" aria-labelledby="productos-heading">
            <div class="w-100 d-flex justify-content-between mb-3 align-items-center flex-wrap gap-2">
                <button wire:click="showCreateForm" class="btn btn-success" aria-label="Crear nuevo producto">
                    Crear nuevo producto
                </button>

                <!-- NO funciona (No está implementado es de decoración 😉 )-->
                <div>
                    <label for="show-count" class="visually-hidden">Número de productos a mostrar</label>
                    <select id="show-count" class="form-select form-select-sm"
                        aria-label="Seleccionar número de productos a mostrar">
                        <option value="5">Mostrar 5 primeros productos</option>
                        <option value="10">Mostrar 10 primeros productos</option>
                        <option value="20">Mostrar 20 primeros productos</option>
                        <option value="50">Mostrar 50 primeros productos</option>
                    </select>
                </div>
            </div>

            <table class="table table-bordered table-striped w-100 align-items-center" role="table"
                aria-describedby="productos-heading">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Características</th>
                        <th scope="col">Tallas</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Rebaja</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
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
                                    <span style="text-decoration: line-through; "
                                        aria-label="Precio original">
                                        {{ number_format($product->price, 2) }}€
                                    </span>
                                    <span class="fw-bold text-danger" aria-label="Precio con descuento">
                                        {{ number_format($product->price - ($product->price * $product->discount) / 100, 2) }}€
                                    </span>
                                @else
                                    {{ number_format($product->price, 2) }}€
                                @endif
                            </td>
                            <td>
                                <button wire:click="edit({{ $product->id }})" class="btn btn-warning btn-sm mt-2"
                                    aria-label="Editar producto {{ $product->name }}" title="Editar producto">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                </button>
                                <button wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm mt-2"
                                    onclick="confirm('¿Estás seguro de eliminar este producto?') || event.stopImmediatePropagation()"
                                    aria-label="Eliminar producto {{ $product->name }}" title="Eliminar producto">
                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                </button>
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
        <h2 class="mb-5 my-4 text-center" role="heading" aria-level="2">
            {{ $product_id ? 'Actualizar' : 'Crear' }} Productos
        </h2>
        <div class="card p-3">

            <form wire:submit.prevent="{{ $product_id ? 'update' : 'store' }}" class="row g-3"
                enctype="multipart/form-data"
                aria-label="{{ $product_id ? 'Formulario para actualizar producto' : 'Formulario para crear producto' }}">
                <div class="col-md-12">
                    <label for="images" class="form-label">Imágenes</label>
                    {{-- Imágenes guardadas en BD --}}
                    @if (count($imagesDB) > 0)
                        <div class="col-md-6 d-flex flex-wrap gap-3 mb-3" role="list"
                            aria-label="Imágenes guardadas">
                            @foreach ($imagesDB as $index => $image)
                                <div style="position: relative; width: 150px; height: 150px;" role="listitem">
                                    <img src="{{ asset('storage/' . $image->url) }}"
                                        alt="Imagen del producto {{ $index + 1 }}" class="rounded w-100 h-100"
                                        style="object-fit: cover;">

                                    <button type="button"
                                        class="btn btn-sm btn-dark position-absolute top-0 end-0 m-1"
                                        style="background-color: rgba(0, 0, 0, 0.5); border: none;"
                                        data-bs-toggle="modal" data-bs-target="#imageModal{{ $index }}"
                                        title="Ver imagen en tamaño grande"
                                        aria-label="Ver imagen {{ $index + 1 }} en tamaño grande">
                                        <i class="bi bi-fullscreen text-light"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-1"
                                        style="background-color: rgba(0, 0, 0, 0.5); border: none;"
                                        wire:click="deleteImage({{ $image->id }})" title="Eliminar imagen"
                                        aria-label="Eliminar imagen {{ $index + 1 }}">
                                        <i class="bi bi-trash text-light"></i>
                                    </button>
                                </div>

                                {{-- Modal de imagen grande --}}
                                <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1"
                                    aria-labelledby="imageModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <img src="{{ asset('storage/' . $image->url) }}"
                                                    alt="Imagen ampliada del producto {{ $index + 1 }}"
                                                    class="img-fluid w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Input para nuevas imágenes --}}
                    <input type="file" wire:model="images" id="images" class="form-control form-control-sm"
                        multiple {{ !$product_id ? 'required' : '' }} aria-describedby="imagesHelp"
                        aria-label="Subir nuevas imágenes del producto">

                    <small id="imagesHelp" class="form-text ">Puedes subir una o más imágenes {{ !$product_id ? '. Campo obligatorio' : '' }}</small>

                    {{-- Previsualización de imágenes nuevas seleccionadas --}}
                    @if (count($images) > 0)
                        <div class="d-flex flex-wrap gap-3 mt-3" role="list"
                            aria-label="Vista previa de nuevas imágenes seleccionadas">
                            @foreach ($images as $key => $tempImage)
                                @if (is_object($tempImage) && method_exists($tempImage, 'temporaryUrl'))
                                    <div style="position: relative; width: 150px; height: 150px;" role="listitem">
                                        <img src="{{ $tempImage->temporaryUrl() }}"
                                            alt="Vista previa de imagen {{ $key + 1 }}"
                                            class="rounded w-100 h-100" style="object-fit: cover;">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-1"
                                            wire:click="removePreviewImage({{ $key }})"
                                            title="Quitar imagen"
                                            aria-label="Quitar imagen previa {{ $key + 1 }}">
                                            <i class="bi bi-trash text-light"></i>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @error('images.*')
                        <small class="text-danger" role="alert">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" id="name" wire:model="name" class="form-control form-control-sm"
                        placeholder="Nombre" required aria-required="true" aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text ">Nombre del producto. Campo obligatorio</small>
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Descripción</label>
                    <input type="text" id="description" wire:model="description"
                        class="form-control form-control-sm" placeholder="Descripción" required aria-required="true"
                        aria-describedby="descriptionHelp">
                    <small id="descriptionHelp" class="form-text ">Descripción breve del producto. Campo obligatorio</small>
                </div>

                <div class="col-md-6">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" id="color" wire:model="color" class="form-control form-control-sm"
                        placeholder="Color" required aria-required="true" aria-describedby="colorHelp">
                    <small id="colorHelp" class="form-text ">Color principal del producto. Campo obligatorio</small>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Género</label>
                    <input type="text" id="gender" wire:model="gender" class="form-control form-control-sm"
                        placeholder="Género" required aria-required="true" aria-describedby="genderHelp">
                    <small id="genderHelp" class="form-text ">Género para el que está pensado el
                        producto. Campo obligatorio</small>
                </div>

                <div class="col-md-6">
                    <label for="style" class="form-label">Estilo</label>
                    <input type="text" id="style" wire:model="style" class="form-control form-control-sm"
                        placeholder="Estilo" required aria-required="true" aria-describedby="styleHelp">
                    <small id="styleHelp" class="form-text ">Estilo del producto. Campo obligatorio</small>
                </div>

                <div class="col-md-6 row mt-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Precio</label>
                        <input type="number" id="price" wire:model="price" class="form-control form-control-sm"
                            placeholder="Precio" step="0.01" required aria-required="true"
                            aria-describedby="priceHelp">
                        <small id="priceHelp" class="form-text ">Precio en moneda local. Campo obligatorio</small>
                    </div>
                    <div class="col-md-6">
                        <label for="discount" class="form-label">Descuento</label>
                        <input type="number" id="discount" wire:model="discount"
                            class="form-control form-control-sm" placeholder="Descuento" step="5"
                            max="90" min="0" aria-describedby="discountHelp">
                        <small id="discountHelp" class="form-text ">Porcentaje de descuento (0-90%)</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label">Categoría</label>
                    <select id="category" wire:model="category" wire:change="filterSizes"
                        class="form-select form-select-sm" required aria-required="true"
                        aria-describedby="categoryHelp">
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    <small id="categoryHelp" class="form-text ">Categoría del producto. Campo obligatorio</small>
                </div>

                <div class="col-md-6">
                    <label for="newCategory" class="form-label">Otra categoría:</label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="newCategory" wire:model="newCategory" class="form-control"
                            placeholder="Nueva Categoría" aria-describedby="newCategoryHelp">
                        <button class="btn btn-outline-dark" type="button" wire:click="addNewCategory"
                            aria-label="Añadir nueva categoría">
                            Añadir
                        </button>
                    </div>
                    <small id="newCategoryHelp" class="form-text ">Escribe una nueva categoría y presiona
                        Añadir</small>
                </div>

                <div class="col-12">
                    <h5 class="my-4" role="heading" aria-level="3">Asignar Stock por Talla</h5>
                    @error('sizes')
                        <div class="text-danger" role="alert">{{ '*Debes asignar stock a al menos una talla.' }}</div>
                    @enderror
                    <small id="sizeHelp" class="form-text mb-1">Es OBLIGATORIO que al menos una talla tenga Stock</small>
                    <div class="d-flex flex-wrap gap-3" role="group" aria-labelledby="sizesLabel">
                        @foreach ($availableSizes as $size)
                            <div class="d-flex align-items-center mb-2">
                                <label for="size-{{ $size->id }}" class="form-label mb-0 me-2"
                                    style="min-width: fit-content;" id="sizesLabel">{{ $size->name }}</label>
                                <input type="number" id="size-{{ $size->id }}"
                                    wire:model="sizes.{{ $size->id }}" class="form-control form-control-sm me-4"
                                    placeholder="Stock" min="0" style="width: 80px;"
                                    aria-describedby="Campo de stock para la talla {{ $size->name }}">
                            </div>
                        @endforeach
                        <div class="d-flex align-items-center mb-2">
                            <label for="newSize" class="form-label mb-0 me-2" style="min-width: fit-content;">Otra
                                talla:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="newSize" wire:model="newSize"
                                    class="form-control form-control-sm" placeholder="Ej: XS, M, XL..."
                                    aria-describedby="newSizeHelp">
                                <button class="btn btn-outline-dark" type="button" wire:click="addNewSize"
                                    aria-label="Añadir nueva talla">
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm"
                        aria-label="{{ $product_id ? 'Actualizar producto' : 'Crear producto' }}">
                        {{ $product_id ? 'Actualizar' : 'Crear' }}
                    </button>
                    <button type="button" wire:click="cancel" class="btn btn-secondary btn-sm"
                        aria-label="Cancelar acción">Cancelar</button>
                </div>
            </form>
        </div>

    @endif

</div>
