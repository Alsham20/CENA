<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Permission;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role as SRole;

class Edit extends Component
{
    public $permissions;

    public $role_permissions = [];

    public $name;

    protected $rules = [
        'name' => 'required|exists:roles,name|min:4',
        'role_permissions.*' => ['nullable', 'exists:permissions,name'],
    ];

    public $role;

    public function mount($role_id = null)
    {
        $this->authorize('edit roles');
        $role = SRole::find($role_id);
        if ($role === null) {
            abort(404);
        }
        $this->role = $role;
        $this->name = $role->name;
        $this->role_permissions = $role->permissions->pluck('name')->toArray();
        $this->permissions = Permission::all();
    }

    public function store()
    {
        $this->authorize('edit roles');
        try {
            DB::beginTransaction();
            $this->validate($this->rules);
            $old_value = json_encode($this->role->permissions()->pluck('name')->toArray());
            $this->role->update(['name' => $this->name]);
            $this->role->syncPermissions($this->role_permissions);

            // ajouter un audit pour l'action de modification de role

            AuditService::log("MODIFICATION D'UN ROLE", $old_value, json_encode($this->role->permissions()->pluck('name')->toArray()), 'Modification de role '.$this->role->name.'avec ses permissions '.$this->role->permissions->pluck('name')->implode(', '));

            $this->dispatch('notification', ['type' => 'success', 'title' => 'Role Modifier', 'message' => 'Role modifier avec succès.']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['type' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Creation | Erreur lors de la modification du role | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        return view('livewire.admin.roles.edit');
    }
}
