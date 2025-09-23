<?php

namespace App\Livewire\Admin\Menus;

use App\Helpers\Helper;
use App\Models\MenuEmplacement;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddMenuEmplacement extends Component
{
    public $label;

    public $code_menu;

    public $description;

    public function render()
    {
        $this->authorize('create menus');

        return view('livewire.admin.menus.add-menu-emplacement');
    }

    public function store()
    {
        $this->authorize('create menus');
        $validated = $this->validate([
            'label' => 'required|min:3',
            'code_menu' => 'nullable|unique:menu_emplacements,code_menu',
            'description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            if ($this->code_menu == null) {
                $validated['code_menu'] = Helper::generateUniqueSlug($this->label, MenuEmplacement::class, 'code_menu');
            }
            $menuEmplacement = MenuEmplacement::create($validated);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Emplacement menu créé avec succès.']);
            $this->reset(['label', 'code_menu', 'description']);
            AuditService::log("CREATION D'UN EMPLACEMENT MENU", null, json_encode($menuEmplacement->toArray()), "Creation de l'emplacement menu ".$menuEmplacement->label);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de l'emplacement menu' | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }
}
