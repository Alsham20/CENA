<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $confirm_delete;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public $types = ['FAQ', 'Page', 'Article', 'Documentation', 'Abonne'];

    public $type;

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
        $this->authorize('list categories');
        AuditService::log('AFFICHAGE DES CATEGORIES', null, null, 'Liste des categories');

    }

    #[On('deleteCategorie')]
    public function deleteCategorie($category_id)
    {
        $this->authorize('delete categories');
        try {
            DB::beginTransaction();
            $category = Category::find($category_id);
            if ($category === null) {
                session()->flash('error', 'Categorie introuvable');

                return;
            }
            $this->deleteChildren($category);
            $category->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE CATEGORIE", null, null, 'Categorie supprime : '.$category->label);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('category-deleted');
            session()->flash('success', 'Categorie supprime avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression de la categorie');
            AuditService::logError('Suppression | Erreur lors de la suppression de la categorie | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        if ($this->search == '') {
            $categories = Category::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $categories = Category::where('label', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->type != '') {
            $categories->where('type', $this->type);
        }
        $categories = $categories->paginate($this->perPage);

        return view('livewire.admin.categories.categories', ['categories' => $categories]);
    }

    private function deleteChildren($category)
    {
        // Récupérer toutes les catégories enfants
        $childCategories = Category::where('parent', $category->id)->get();

        // Supprimer récursivement chaque enfant
        foreach ($childCategories as $childCategory) {
            $this->deleteChildren($childCategory); // Appel récursif
            $childCategory->delete(); // Supprimer la catégorie enfant
        }
    }
}
