<?php

namespace App\Livewire\Admin;

use App\Models\Permission;
use App\Services\AuditService;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionsComponent extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function mount()
    {
        $this->authorize('list permissions');
        AuditService::log('AFFICHAGE DES PERMISSIONS', null, null, 'Liste des permissions');
    }

    public function render()
    {
        if ($this->search == '') {
            $permissions = Permission::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.permissions-component', ['permissions' => $permissions]);
    }
}
