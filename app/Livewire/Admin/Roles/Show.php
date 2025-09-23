<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Permission;
use Livewire\Component;
use Spatie\Permission\Models\Role as SRole;

class Show extends Component
{
    public $permissions;

    public $role_permissions = [];

    public $name;

    public $role;

    public function mount($role_id = null)
    {
        $this->authorize('view roles');
        $role = SRole::find($role_id);
        if ($role === null) {
            abort(404);
        }
        $this->role = $role;
        $this->name = $role->name;
        $this->role_permissions = $role->permissions->pluck('name')->toArray();
        $this->permissions = Permission::all();
    }

    public function render()
    {
        return view('livewire.admin.roles.show');
    }
}
