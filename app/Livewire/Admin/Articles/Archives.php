<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Archives extends Component
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

    public $activity = -1;

    public $activities;

    public $type;

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

    public function mount()
    {
        $this->authorize('list archive');
        $this->categories = Category::where('type', 'Article')->get();
        $this->activities = Activity::where('type', 'Article')->get();
        AuditService::log('AFFICHAGE DES ARCHIVES', null, null, 'Liste des archives');
    }

    #[On('deleteArticle')]
    public function deleteArticle($article_id)
    {
        $this->authorize('delete articles');
        try {
            DB::beginTransaction();
            $article = Article::find($article_id);
            if ($article === null) {
                session()->flash('error', 'Article introuvable');

                return;
            }
            $article->is_deleted = true;
            $article->save();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN ARTICLE", null, null, 'Article supprimé : ' . $article->title);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('article-deleted');
            session()->flash('success', 'Article supprimé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression de l\'article');
            AuditService::logError('Suppression | Erreur lors de la suppression de l\'article | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unarchiveArticle($article_id)
    {
        $this->authorize('unarchive articles');
        try {
            DB::beginTransaction();
            $article = Article::find($article_id);
            if ($article === null) {
                session()->flash('error', 'Article introuvable');

                return;
            }
            $article->is_archive = false;
            $article->save();
            // ajouter un audit
            AuditService::log("DESARCHIVAGE D'UN ARTICLE", null, null, 'Article désarchivé : ' . $article->title);
            DB::commit();
            session()->flash('success', 'Article archivé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors du désarchivage de l\'article');
            AuditService::logError('Désarchivage | Erreur lors du désarchivage de l\'article | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $articles = Article::where('is_deleted', false)->where('is_archive', true)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $articles = Article::where('is_deleted', false)->where('is_archive', true)->where('title', 'like', '%' . $this->search . '%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->type != '') {
            $articles->where('is_private', (int) $this->type);
        }

        if ($this->category != -1) {
            $articles->where('category', (int) $this->category);
        }

        if ($this->status != '') {
            $articles->where('is_published', (int) $this->status);
        }
        $articles = $articles->paginate($this->perPage);

        return view('livewire.admin.articles.archives', ['articles' => $articles]);
    }
}
