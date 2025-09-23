<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Menus extends Component
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
        AuditService::log('AFFICHAGE DES MENUS', null, null, 'Liste des menus');

    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete menus');
        try {
            DB::beginTransaction();
            $menu = Menu::find($id);
            if ($menu === null) {
                session()->flash('error', 'Menu introuvable');

                return;
            }
            $menu->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN MENU", null, null, 'Menu supprimé : '.$menu->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('menu-deleted');
            session()->flash('success', 'Menu supprimé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression des menus');
            AuditService::logError('Suppression | Erreur lors de la suppression des menus | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        if ($this->search == '') {
            $menus = Menu::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $terms = explode(' ', $this->search);
            $query = Menu::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('label', 'LIKE', "%{$term}%")
                        ->orWhere('primary_title', 'LIKE', "%{$term}%")
                        ->orWhere('url', 'LIKE', "%{$term}%")
                        ->orWhere('icon', 'LIKE', "%{$term}%")
                        ->orWhere('permission', 'LIKE', "%{$term}%")
                        ->orWhere('secondary_title', 'LIKE', "%{$term}%");
                });
            }
            $menus = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.menus.menus', ['menus' => $menus]);
    }
}
