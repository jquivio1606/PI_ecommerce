<div>
    @if ($view == 'list')
        <h2 class="mb-5 my-4 text-center">Ver datos de los Productos</h2>
        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong>Filtrar Usuarios</strong>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="filter" class="row g-3 align-items-end">
                    <div class="col-md">
                        <label for="filterName" class="form-label">Nombre</label>
                        <input type="text" id="filterName" name="filterName" wire:model.defer="filterName" class="form-control" placeholder="Ej: María">
                    </div>

                    <div class="col-md">
                        <label for="filterRole" class="form-label">Rol</label>
                        <select id="filterRole" name="filterRole" wire:model.defer="filterRole" class="form-select">
                            <option value="">-- Todos --</option>
                            @foreach ($roles as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
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
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div style="width: 100%; overflow-x: auto;">
            <!-- Tabla usuarios -->
            <table class="table table-bordered table-striped w-100 align-items-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role == 1 ? 'Administrador' : 'Usuario' }}</td>
                            <td>
                                <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button wire:click="delete({{ $user->id }})" class="btn btn-sm btn-danger"
                                    onclick="confirm('¿Estás seguro de eliminar este usuario?') || event.stopImmediatePropagation()">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if ($view == 'form')
        <h2 class="mb-5 my-4 text-center">Editar Usuario</h2>

        <div class="card p-3">
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" id="name" name="name" wire:model.defer="name" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" wire:model.defer="email" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rol:</label>
                    <select id="role" name="role" wire:model.defer="role" class="form-select">
                        <option value="">Selecciona un rol</option>
                        <option value="0">Usuario</option>
                        <option value="1">Administrador</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $errors->first('role') }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <button type="button" wire:click="cancel" class="btn btn-secondary ms-2">Cancelar</button>
            </form>
        </div>
    @endif
</div>
