<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use App\Services\AuditService;
use Livewire\Component;
use Livewire\WithPagination;

class RolesComponent extends Component
{
    use WithPagination;

    protected $listeners = ['roleUpdated' => 'render'];

    public $confirm_delete;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public $permissions = [];

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function delete($role_id)
    {
        $this->authorize('delete roles');
        try {
            $role = Role::find($role_id);
            if ($role === null || User::Role($role->name)->count() > 0) {

                $this->dispatch('role-deleted');
                $this->dispatch('notification', ['type' => 'error', 'title' => 'Erreur', 'message' => 'Role introuvable ou est utilisé par des utilisateurs']);

                return;
            }
            $role->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN ROLE", null, json_encode($role), 'Role supprime : '.$role->name.' avec ses permissions '.$role->permissions->pluck('name')->implode(', '));
            $this->confirm_delete = null;
            $this->dispatch('role-deleted');
            $this->dispatch('notification', ['type' => 'success', 'title' => 'Role Supprime', 'message' => 'Role supprime avec succès']);
            $this->resetPage();
        } catch (\Throwable $th) {
            $this->dispatch('notification', ['type' => 'error', 'title' => 'Erreur', 'message' => 'Erreur lors de la suppression du role']);
            AuditService::logError('Suppression | Erreur lors de la suppression du role | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function mount()
    {
        $this->authorize('list roles');

    }

    public function render()
    {
        if ($this->search != '') {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $roles = Role::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.roles-component', ['roles' => $roles]);
    }
}
