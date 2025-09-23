<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Add extends Component
{
    public $label;

    public $type;

    public $types = ['FAQ', 'Page', 'Article', 'Documentation', 'Abonne'];

    public $parent;

    public $author;

    public $categories;

    public function mount()
    {
        $this->categories = Category::all();

    }

    public function store()
    {
        $this->authorize('create categories');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'label' => 'required|min:3',
            'type' => 'required|in:'.implode(',', $this->types),
            'parent' => 'nullable|exists:categories,id',
            'author' => 'nullable|exists:users,id',
        ]);
        try {
            DB::beginTransaction();

            $category = Category::create($validated);
            DB::commit();
            $this->reset(['label', 'type', 'parent']);
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Catégorie Créée', 'message' => 'Catégorie créée avec succès.']);
            AuditService::log("CREATION D'UNE CATEGORIE", null, json_encode($category->toArray()), 'Creation de categorie '.$category->name);

        } catch (\Throwable $th) {
            DB::rollBack();
            // session()->flash('error', $th->getMessage());
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);

            AuditService::logError("Creation | Erreur lors de l'ajout de la catégorie | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        return view('livewire.admin.categories.add');
    }
}
