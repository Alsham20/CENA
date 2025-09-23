<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $label;

    public $type;

    public $types = ['FAQ', 'Page', 'Article', 'Abonne', 'Documentation'];

    public $parent;

    protected $author;

    public $category;

    public $categories;

    public function mount($category_id)
    {
        $this->authorize('edit categories');
        $category = Category::find($category_id);
        if ($category === null) {
            abort(404);
        }
        $this->label = $category->label;
        $this->type = $category->type;
        $this->parent = $category->parent;
        $this->author = $category->author;
        $this->category = $category;

        $this->categories = Category::all();

    }

    public function store()
    {
        $this->authorize('edit categories');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'label' => 'required|min:3',
            'type' => 'required|in:'.implode(',', $this->types),
            'parent' => 'nullable|exists:categories,id',
        ]);
        try {
            DB::beginTransaction();

            $category = $this->category;
            $old = $category->toArray();
            $category->update($validated);

            DB::commit();
            // session()->flash('success', "Categorie modifier avec succès.");
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Catégorie modifiée avec succès.']);

            AuditService::log("MODIFICATION D'UNE CATEGORIE", json_encode($old), json_encode($category->toArray()), 'Modification de categorie '.$category->label);

        } catch (\Throwable $th) {
            DB::rollBack();
            // session()->flash('error', $th->getMessage());
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Modification | Erreur lors de la modification de la categorie | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        return view('livewire.admin.categories.edit');
    }
}
