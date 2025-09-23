<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Pagination extends Component
{
    use WithPagination;

    public $currentPage;

    public $lastPage;

    public $data;

    public function mount($paginator)
    {
        $this->currentPage = $paginator->currentPage();
        $this->lastPage = $paginator->lastPage();
        $this->data = $paginator->items(); // ou `data`
    }

    public function render()
    {
        return view('livewire.admin.pagination');
    }
}
