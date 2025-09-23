<?php

namespace App\Livewire\Admin;

use App\Models\Permission;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role as SRole;

class CreateRoleComponent extends Component
{
    public $permissions;

    public $role_permissions = [];

    public $name;

    protected $rules = [
        'name' => 'required|unique:roles,name|min:4',
        'role_permissions.*' => ['nullable', 'exists:permissions,name'],
    ];

    public function mount()
    {
        $this->authorize('create roles');
        $this->permissions = Permission::all();
    }

    public function store()
    {
        $this->authorize('create roles');
        try {
            DB::beginTransaction();
            $this->validate($this->rules);
            $role = SRole::create(['name' => $this->name]);
            $role->givePermissionTo($this->role_permissions);

            $this->resetInputFields();
            // ajouter un audit pour l'action de creation de role

            AuditService::log("CREATION D'UN ROLE", null, json_encode($role->permissions()->pluck('name')->toArray()), 'Creation de role '.$role->name.'avec ses permissions '.$role->permissions->pluck('name')->implode(', '));

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Rôle Ajouté', 'message' => 'Rôle ajouté avec succès.']);
            DB::commit();
            $this->dispatch('roleCreated');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Création | Erreur lors de l'ajout du rôle | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        return view('livewire.admin.create-role-component');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->role_permissions = [];
    }
}
