<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use App\Models\MenuEmplacement;
use App\Services\AuditService;
use Livewire\Component;

class ShowMenuEmplacement extends Component
{
    #[Url(as: 'ude')]
    public $menu_emplacement_id;

    public MenuEmplacement $menuEmplacement;

    public $menus = [];

    public function mount($menu_emplacement_id = null)
    {
        $this->authorize('view menus');

        $this->menu_emplacement_id = $menu_emplacement_id;
        $menuEmplacement = MenuEmplacement::find($this->menu_emplacement_id);
        $menus = Menu::where('menu_emplacement_id', $this->menu_emplacement_id)->whereNull('parent_id')->with('children')->orderBy('position')->get();
        if ($menuEmplacement === null) {
            // TODO : afficher message d'erreur
            abort(404);
        }
        $this->menuEmplacement = $menuEmplacement;
        $this->menus = $menus;

        // TODO : Ajouter un audit
        AuditService::log("DETAILS D'UN EMPLACEMENT MENU", null, null, 'Consultation du profil de l\'emplacement menu : '.$this->menuEmplacement->label);
    }

    public function render()
    {
        return view('livewire.admin.menus.show-menu-emplacement');
    }
}
