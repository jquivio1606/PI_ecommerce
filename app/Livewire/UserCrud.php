<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserCrud extends Component
{
    public $users, $user_id, $name, $email, $role;
    public $filterName = '';
    public $filterRole = '';

    public $roles = [
        '0' => 'Usuario',
        '1' => 'Administrador',
    ];

    public $view = 'list'; // 'list' o 'form'

    public function mount()
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.user-crud');
    }

    public function filter()
    {
        $query = User::query();

        if (!empty($this->filterName)) {
            $query->where('name', 'like', '%' . $this->filterName . '%');
        }

        if ($this->filterRole !== '') {
            $query->where('role', $this->filterRole);
        }

        $this->users = $query->get();

        if ($this->users->isEmpty()) {
            session()->flash('error', 'No se encontraron usuarios con esos filtros.');
            $this->users = User::all();
        }
    }

    public function resetFilters()
    {
        $this->filterName = '';
        $this->filterRole = '';
        $this->users = User::all();
    }
    public function resetInputs()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->role = '';
    }

    public function showCreateForm()
    {
        $this->resetInputs();
        $this->view = 'form';
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->fill($user->toArray());
        $this->view = 'form';
    }

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
        $this->users = User::all();
    }

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
        $this->users = User::all();
    }

    public function cancel()
    {
        $this->resetInputs();
        $this->view = 'list';
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Usuario eliminado correctamente.');
        $this->users = User::all();
    }

    private function validateData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
