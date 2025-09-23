<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use App\Models\MenuEmplacement;
use App\Models\Permission;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Add extends Component
{
    public $primary_title;

    public $secondary_title;

    public $label;

    public $url;

    public $avatar;

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

    public function mount()
    {
        $this->authorize('create menus');
        $this->loadData();

    }

    public function store()
    {
        $this->authorize('create menus');
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
            $menu = Menu::create($validated);

            session()->flash('status', 'Menu créé avec succès.');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Succès', 'message' => 'Menu ajoute avec succès.']);
            $this->reset(['label', 'url', 'parent_id', 'primary_title', 'secondary_title', 'icon', 'permission', 'menu_emplacement_id', 'position', 'new_tab']);
            $this->dispatch('resetEditors');
            $this->loadData();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Menu créé avec succès.']);

            $this->dispatch('menu-added');
            AuditService::log("CREATION D'UN MENU", null, json_encode($menu->toArray()), 'Creation du menu '.$menu->label);
            DB::commit();
        } catch (\Throwable $th) {

            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout du menu' | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        return view('livewire.admin.menus.add');
    }

    public function loadData()
    {
        $this->menus = Menu::all();
        $this->menuEmplacements = MenuEmplacement::all();
        $this->permissions = Permission::all();
    }
}
