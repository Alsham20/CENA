<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use App\Models\MenuEmplacement;
use App\Models\Permission;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $label;

    public $icon;

    public $permission;

    public $menu_emplacement_id;

    public $position = 0;

    public $new_tabs = ['Non', 'Oui'];

    public $new_tab = false;

    public $parent_id;

    public $menus = [];

    public $menuEmplacements = [];

    public $permissions = [];

    public $menu;

    public $primary_title;

    public $secondary_title;

    public $url;

    public function mount($menu_id)
    {
        $this->authorize('edit menus');
        $this->loadData();

        $this->menu = Menu::findOrFail($menu_id);
        $this->label = $this->menu->label;
        $this->icon = $this->menu->icon;
        $this->permission = $this->menu->permission;
        $this->menu_emplacement_id = $this->menu->menu_emplacement_id;
        $this->position = $this->menu->position;
        $this->new_tab = $this->menu->new_tab;
        $this->parent_id = $this->menu->parent_id;
        $this->primary_title = $this->menu->primary_title;
        $this->secondary_title = $this->menu->secondary_title;
        $this->url = $this->menu->url;

    }

    public function store()
    {
        $this->authorize('edit menus');
        $validated = $this->validate([
            'label' => 'required|min:3',
            'url' => 'required',
            'parent_id' => 'nullable|exists:menus,id',
            'primary_title' => 'nullable',
            'icon' => 'nullable',
            'secondary_title' => 'nullable',
            'menu_emplacement_id' => 'required|exists:menu_emplacements,id',
            'permission' => 'nullable|exists:permissions,name',
            'position' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $menu = $this->menu;
            $old = $menu->toArray();
            $menu->update($validated);

            session()->flash('status', 'Menu modifié avec succès.');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Succès', 'message' => 'Menu modifié avec succès.']);
            //$this->reset(['label', 'url', 'parent_id', 'primary_title', 'secondary_title', 'icon', 'permission', 'menu_emplacement_id', 'position', 'new_tab']);
            $this->dispatch('resetEditors');
            $this->loadData();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Menu créé avec succès.']);

            $this->dispatch('menu-added');
            AuditService::log("MODIFICATION D'UN MENU", json_encode($old), json_encode($menu->toArray()), 'Creation du menu '.$this->label);
            DB::commit();
            $this->redirectRoute('menus.index');
        } catch (\Throwable $th) {

            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Modification | Erreur lors de la modification du menu' | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        return view('livewire.admin.menus.edit');
    }

    public function loadData()
    {
        $this->menus = Menu::all();
        $this->menuEmplacements = MenuEmplacement::all();
        $this->permissions = Permission::all();
    }
}
