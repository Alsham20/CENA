<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use App\Models\MenuEmplacement;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MenuEmplacements extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function mount()
    {
        $this->authorize('list menus');
        AuditService::log('AFFICHAGE DES EMPLACEMENTS MENUS', null, null, 'Liste des emplacements menus');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete menus');
        try {
            DB::beginTransaction();
            $menuEmplacement = MenuEmplacement::find($id);
            if ($menuEmplacement === null) {
                session()->flash('error', 'Emplacement introuvable');

                return;
            }
            Menu::where('menu_emplacement_id', $menuEmplacement->id)->delete();
            $menuEmplacement->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN EMPLACEMENT MENU", null, null, 'Emplacement menu supprimé : '.$menuEmplacement->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('menu-deleted');
            session()->flash('success', 'Emplacement menu supprimé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression des emplacements menus');
            AuditService::logError('Suppression | Erreur lors de la suppression des emplacements menus | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        if ($this->search == '') {
            $menuEmplacements = MenuEmplacement::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $terms = explode(' ', $this->search);
            $query = MenuEmplacement::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('label', 'LIKE', "%{$term}%")
                        ->orWhere('code_menu', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%");
                });
            }
            $menuEmplacements = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.menus.menu-emplacements', ['menuEmplacements' => $menuEmplacements]);
    }
}
