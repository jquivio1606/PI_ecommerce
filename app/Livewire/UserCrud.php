<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserCrud extends Component
{
    // Variables públicas que se vinculan a la vista (Livewire data binding)
    public $users, $user_id, $name, $email, $role;
    public $filterName = '';                                            // Filtro para buscar por nombre
    public $filterRole = '';                                            // Filtro para buscar por rol

    // Roles definidos para mostrar en un select (clave => valor)
    public $roles = [
        '0' => 'Usuario',
        '1' => 'Administrador',
    ];

    // Controla la vista actual, puede ser 'list' o 'form'
    public $view = 'list';

    /**
     * Método que se ejecuta automáticamente al instanciar el componente
     * Se usa para inicializar datos, en este caso cargar todos los usuarios
     */
    public function mount()
    {
        $this->loadUsers();
    }

    /**
     * Renderiza la vista del componente Livewire
     */
    public function render()
    {
        return view('livewire.user-crud');
    }

    /**
     * Aplica filtros para buscar usuarios por nombre y rol
     * Construye una consulta dinámica basada en los filtros proporcionados
     *
     * Línea clave: $query = User::query(); // Inicia la consulta para el modelo User
     * La función where con 'like' permite buscar coincidencias parciales en el nombre
     */
    public function filter()
    {
        $query = User::query();

        if (!empty($this->filterName)) {
            // Busca usuarios cuyo nombre contenga el texto del filtro (consulta LIKE)
            $query->where('name', 'like', '%' . $this->filterName . '%');
        }

        if ($this->filterRole !== '') {
            // Filtra por rol exacto
            $query->where('role', $this->filterRole);
        }

        // Ejecuta la consulta y guarda los resultados en $this->users
        $this->users = $query->get();

        if ($this->users->isEmpty()) {
            // Si no hay resultados, muestra mensaje de error y recarga todos usuarios
            session()->flash('error', 'No se encontraron usuarios con esos filtros.');
            $this->loadUsers();
        }
    }

    /**
     * Resetea los filtros a su estado inicial (vacío)
     * y recarga todos los usuarios sin filtro
     */
    public function resetFilters()
    {
        $this->filterName = '';
        $this->filterRole = '';
        $this->loadUsers();
    }

    /**
     * Limpia los campos del formulario, útil antes de crear un nuevo usuario o cancelar edición
     */
    public function resetInputs()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->role = '';
    }

    /**
     * Cambia la vista para mostrar el formulario para crear un nuevo usuario
     * Además, limpia los campos del formulario para que no queden datos anteriores
     */
    public function showCreateForm()
    {
        $this->resetInputs();
        $this->view = 'form';
    }

    /**
     * Carga los datos de un usuario específico para editarlo
     *
     * findOrFail: busca el usuario por id y lanza error si no existe
     * fill: método Livewire para rellenar varias propiedades a la vez desde un array
     * Cambia la vista a formulario para que se muestre el formulario de edición
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->fill($user->toArray());
        $this->view = 'form';
    }

    /**
     * Valida los datos ingresados y crea un nuevo usuario en la base de datos
     * Reglas de validación:
     *  - name requerido, tipo string y max 255 caracteres
     *  - email requerido, formato email válido y único en la tabla users
     *  - role requerido y debe ser 0 o 1
     * Luego crea el usuario con los datos validados y limpia el formulario
     * Muestra mensaje de éxito y vuelve a la lista de usuarios
     */
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:0,1',
        ]);

        User::create($this->validateData());

        session()->flash('message', 'Usuario creado correctamente.');
        $this->resetInputs();
        $this->view = 'list';
        $this->loadUsers();
    }

    /**
     * Valida los datos ingresados y actualiza un usuario existente
     * La validación para email usa unique ignorando el email del usuario actual (para que no choque con sí mismo)
     * Actualiza el registro en base a $this->user_id
     * Limpia formulario y vuelve a la lista con mensaje de éxito
     */
    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required|in:0,1',
        ]);

        $user = User::findOrFail($this->user_id);
        $user->update($this->validateData());

        session()->flash('message', 'Usuario actualizado correctamente.');
        $this->resetInputs();
        $this->view = 'list';
        $this->loadUsers();
    }

    /**
     * Cancela la edición o creación actual
     * Limpia el formulario y vuelve a la vista de listado
     */
    public function cancel()
    {
        $this->resetInputs();
        $this->view = 'list';
    }

    /**
     * Elimina un usuario por su ID
     * findOrFail elimina si lo encuentra, si no lanza error
     * Luego muestra mensaje y recarga la lista de usuarios
     */
    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Usuario eliminado correctamente.');
        $this->loadUsers();
    }

    /**
     * Método privado para cargar todos los usuarios en la variable pública $users
     * Se separó para evitar repetir código en varias funciones
     */
    private function loadUsers()
    {
        $this->users = User::all();
    }

    /**
     * Método privado que retorna los datos que serán validados y usados para crear o actualizar usuario
     */
    private function validateData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
