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

class Articles extends Component
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
        $this->authorize('list articles');
        $this->categories = Category::where('type', 'Article')->get();
        $this->activities = Activity::where('type', 'Article')->get();
        AuditService::log('AFFICHAGE DES ARTICLES', null, null, 'Liste des articles');
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

    public function publishArticle($article_id)
    {
        $this->authorize('publish articles');
        try {
            DB::beginTransaction();
            $article = Article::find($article_id);
            if ($article === null) {
                session()->flash('error', 'Article introuvable');

                return;
            }
            $article->is_published = true;
            $article->save();
            // ajouter un audit
            AuditService::log("PUBLICATION D'UN ARTICLE", null, null, 'Article publie : ' . $article->title);
            DB::commit();
            session()->flash('success', 'Article publie avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la publication de l\'article');
            AuditService::logError('Publication | Erreur lors de la publication de l\'article | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function archiveArticle($article_id)
    {
        $this->authorize('archive articles');
        try {
            DB::beginTransaction();
            $article = Article::find($article_id);
            if ($article === null) {
                session()->flash('error', 'Article introuvable');

                return;
            }
            $article->is_archive = true;
            $article->save();
            // ajouter un audit
            AuditService::log("ARCHIVAGE D'UN ARTICLE", null, null, 'Article archivé : ' . $article->title);
            DB::commit();
            session()->flash('success', 'Article archivé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'archivage de l\'article');
            AuditService::logError('Archivage | Erreur lors de l\'archivage de l\'article | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishArticle($article_id)
    {
        $this->authorize('unpublish articles');
        try {
            DB::beginTransaction();
            $article = Article::find($article_id);
            if ($article === null) {
                session()->flash('error', 'Article introuvable');

                return;
            }
            $article->is_published = false;
            $article->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UN ARTICLE", null, null, 'Article desactive : ' . $article->title);
            DB::commit();
            session()->flash('success', 'Article desactive avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la desactivation de l\'article');
            AuditService::logError('Desactivation | Erreur lors de la desactivation de l\'article | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $articles = Article::where('is_deleted', false)->where('is_archive', false)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $articles = Article::where('is_deleted', false)->where('is_archive', false)->where('title', 'like', '%' . $this->search . '%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
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

        return view('livewire.admin.articles.articles', ['articles' => $articles]);
    }
}
