<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Services\AuditService;
use Livewire\Component;

class Show extends Component
{
    public $label;

    public $type;

    public $types = ['FAQ', 'Page', 'Article', 'Abonne', 'Documentation'];

    public $parent;

    public $author;

    public $category;

    public $categories;

    public function mount($category_id)
    {
        $this->authorize('view categories');
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

        AuditService::log("AFFICHAGE D'UNE CATEGORIE", null, null, 'Affichage de la categorie '.$category->label);

    }

    public function render()
    {
        return view('livewire.admin.categories.show');
    }
}
