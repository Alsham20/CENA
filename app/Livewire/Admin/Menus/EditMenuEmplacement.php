<?php

namespace App\Livewire\Admin\Menus;

use App\Helpers\Helper;
use App\Models\MenuEmplacement;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditMenuEmplacement extends Component
{
    public $label;

    public $code_menu;

    public $description;

    public $menu_emplacement_id;

    public function mount($menu_emplacement_id)
    {
        $this->authorize('edit menus');
        $this->label = MenuEmplacement::findOrFail($menu_emplacement_id)->label;
        $this->code_menu = MenuEmplacement::findOrFail($menu_emplacement_id)->code_menu;
        $this->description = MenuEmplacement::findOrFail($menu_emplacement_id)->description;
    }

    public function render()
    {
        $this->authorize('edit menus');

        return view('livewire.admin.menus.edit-menu-emplacement');
    }

    public function store()
    {
        $this->authorize('edit menus');
        $validated = $this->validate([
            'label' => 'required|min:3',
            'code_menu' => 'nullable',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            if ($this->code_menu == null) {
                $validated['code_menu'] = Helper::generateUniqueSlug($this->label, MenuEmplacement::class, 'code_menu');
            }
            $old = MenuEmplacement::findOrFail($this->menu_emplacement_id)->toArray();
            $menuEmplacement = MenuEmplacement::updateOrCreate(['id' => $this->menu_emplacement_id], $validated);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Emplacement menu modifié avec succès.']);
            $this->reset(['label', 'code_menu', 'description']);
            AuditService::log("MODIFICATION D'UN EMPLACEMENT MENU", json_encode($old), json_encode($menuEmplacement->toArray()), "Modification de l'emplacement menu ".$menuEmplacement->label);
            $this->redirectRoute('menu-emplacements.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Modification | Erreur lors de la modification de l'emplacement menu' | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }
}
