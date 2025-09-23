<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;

class Show extends Component
{
    public $page_id;

    public function mount($page_id)
    {
        $this->authorize('view pages');
        $this->page_id = $page_id;

    }

    public function render()
    {
        $page = Page::find($this->page_id);
        if ($page === null) {
            abort(404);
        }

        return view('livewire.admin.pages.show', [
            'page' => $page,
        ]);
    }
}
