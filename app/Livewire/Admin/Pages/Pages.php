<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Category;
use App\Models\Page;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;

    public $confirm_delete;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $category = -1;

    public $categories;

    public $status;

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
        $this->authorize('list pages');
        $this->categories = Category::where('type', 'page')->get();
        AuditService::log('AFFICHAGE DES PAGES', null, null, 'Liste des pages');
    }

    #[On('deletePage')]
    public function deletePage($page_id)
    {
        $this->authorize('delete pages');
        try {
            DB::beginTransaction();
            $page = Page::find($page_id);
            if ($page === null) {
                session()->flash('error', 'Page introuvable');

                return;
            }
            $page->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE PAGE", null, null, 'Page supprime : '.$page->id);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('page-deleted');
            session()->flash('success', 'Page supprime avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la suppression de la page');
            AuditService::logError('Suppression | Erreur lors de la suppression de la page | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function publishPage($page_id)
    {
        $this->authorize('publish pages');
        try {
            DB::beginTransaction();
            $page = Page::find($page_id);
            if ($page === null) {
                session()->flash('error', 'Page introuvable');

                return;
            }
            $page->is_published = true;
            $page->save();
            // ajouter un audit
            AuditService::log("PUBLICATION D'UNE PAGE", null, null, 'Page publiee : '.$page->id);
            DB::commit();
            session()->flash('success', 'Page publiée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la publication de la page');
            AuditService::logError('Publication | Erreur lors de la publication de la page | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishPage($page_id)
    {
        $this->authorize('publish pages');
        try {
            DB::beginTransaction();
            $page = Page::find($page_id);
            if ($page === null) {
                session()->flash('error', 'Page introuvable');

                return;
            }
            $page->is_published = false;
            $page->save();
            // ajouter un audit
            AuditService::log("DEPUBLICATION D'UNE PAGE", null, null, 'Page depubliee : '.$page->label);
            DB::commit();
            session()->flash('success', 'Page dépubliée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la depublication de la page');
            AuditService::logError('Depublication | Erreur lors de la depublication de la page | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $pages = Page::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $pages = Page::where('title', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->category != -1) {
            $pages->where('category', (int) $this->category);
        }

        if ($this->status != '') {
            $pages->where('is_published', (int) $this->status);
        }
        $pages = $pages->paginate($this->perPage);

        return view('livewire.admin.pages.pages', ['pages' => $pages]);
    }
}
