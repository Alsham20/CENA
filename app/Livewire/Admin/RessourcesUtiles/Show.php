<?php

namespace App\Livewire\Admin\RessourcesUtiles;

use App\Models\Category;
use App\Models\RessourcesUtile;
use Livewire\Component;

class Show extends Component
{
    public $name;

    public $description;

    public $doc_id;

    public $categorie_id;

    public $doc_type;

    public $doc_size;

    public $doc_path;

    public $attached_file_;

    public $categories = [];

    public $ressourceUtile;

    public function mount($id)
    {
        $this->authorize('view documentation');
        $this->categories = Category::where('type', 'Documentation')->get();
        $ressourceUtile = RessourcesUtile::where('id', $id)->first();

        if ($ressourceUtile == null) {
            abort(404);
        }
        $this->ressourceUtile = $ressourceUtile;
        $this->name = $ressourceUtile->name;
        $this->description = $ressourceUtile->description;
        $this->categorie_id = $ressourceUtile->categorie_id;
        $this->doc_id = $ressourceUtile->doc_id;
        $this->doc_type = $ressourceUtile->doc_type;
        $this->doc_size = $ressourceUtile->doc_size;
        $this->doc_path = $ressourceUtile->doc_path;
    }

    public function render()
    {
        return view('livewire.admin.ressources-utiles.show');
    }
}
