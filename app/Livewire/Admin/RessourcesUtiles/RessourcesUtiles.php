<?php

namespace App\Livewire\Admin\RessourcesUtiles;

use App\Models\Category;
use App\Models\RessourcesUtils;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RessourcesUtiles extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $confirm_delete;

    public $categories = [];

    public $categorie;

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
        $this->authorize('list documentation');
        $this->categories = Category::where('type', 'Documentation')->get();
        AuditService::log('AFFICHAGE DES Documentation', null, null, 'Liste des documentation');
    }

    public function render()
    {
        if ($this->search == '') {
            $ressources = RessourcesUtils::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = RessourcesUtils::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'LIKE', "%{$term}%")
                        ->orWhere('doc_type', 'LIKE', "%{$term}%")
                        ->orWhere('doc_size', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%")
                        ->orWhere('doc_path', 'LIKE', "%{$term}%");
                });
            }
            $ressources = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->categorie != '') {
            $ressources->where('categorie_id', $this->categorie);
        }
        $ressources = $ressources->paginate($this->perPage);

        return view('livewire.admin.ressources-utiles.ressources-utiles', ['ressources' => $ressources]);
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete documentation');
        try {
            DB::beginTransaction();
            $ressource = RessourcesUtils::find($id);
            if ($ressource === null) {
                session()->flash('error', 'Ressource utile introuvable');

                return;
            }
            $ressource->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE RESSOURCE UTILE", null, null, 'Ressource utile supprime : '.$ressource->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('ressource-deleted');
            session()->flash('success', 'Ressource utile supprimée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression des ressources');
            AuditService::logError('Suppression | Erreur lors de la suppression de la ressource | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }
}
