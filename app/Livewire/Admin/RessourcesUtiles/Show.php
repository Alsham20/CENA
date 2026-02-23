<?php

namespace App\Livewire\Admin\RessourcesUtiles;

use App\Models\Category;
use App\Models\RessourcesUtile;
use App\Models\RessourcesUtils;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $name;

    public $object;

    public $description;

    public $doc_id;

    public $category;

    public $doc_type;

    public $doc_size;

    public $doc_path;

    public $attached_file_;

    public $categories = [];

    public $date_creation;

    public $ressourceUtile;

    public function mount($id)
    {
        $this->authorize('view documentation');
        $this->categories = Category::where('type', 'Documentation')->get();
        $ressourceUtile = RessourcesUtils::where('id', $id)->first();

        if ($ressourceUtile == null) {
            abort(404);
        }
        $this->ressourceUtile = $ressourceUtile;
        $this->name = $ressourceUtile->name;
        $this->object = $ressourceUtile->object;
        $this->description = $ressourceUtile->description;
        $this->category = $ressourceUtile->category;
        $this->doc_id = $ressourceUtile->doc_id;
        $this->doc_type = $ressourceUtile->doc_type;
        $this->doc_size = $ressourceUtile->doc_size;
        $this->doc_path = $ressourceUtile->doc_path;
        $this->date_creation = ($ressourceUtile->date_creation)  ? Carbon::parse($ressourceUtile->date_creation)->format('Y-m-d') : '';
    }

    public function render()
    {
        return view('livewire.admin.ressources-utiles.show');
    }
}
