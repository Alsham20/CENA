<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Articles;

use App\Mail\ArticleMail;
use App\Models\Article;
use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $title;

    public $content;

    public $author;

    public $category;

    // public $images = [];
    public $poster;

    public $poster_url;

    public $resume;

    public $tags;

    public $slug_;

    public $content_keywords;

    public $content_description;

    public $is_featured = false;

    public $is_private = false;

    public $article_id;

    public $categories = [];

    public $date_article;

    public $modalWidget;

    public function mount($article_id): void
    {
        $this->authorize('edit articles');
        $article = Article::find($article_id);
        if ($article === null) {
            abort(404);
        }
        $this->title = $article->title;
        $this->content = $article->content;
        // $this->author = $article->author;
        $this->category = $article->category;
        $this->poster = $article->poster;

        if ($this->poster !== null) {
            $media = Media::find($this->poster);
            $this->poster_url = $media->getUrlThumbnail();
        }
        $this->resume = $article->resume;
        $this->tags = json_decode($article->tags);
        $this->slug_ = $article->slug;
        $this->content_keywords = json_decode($article->content_keywords);
        $this->content_description = $article->content_description;
        $this->is_featured = $article->is_featured;
        $this->is_private = $article->is_private;
        $this->article_id = $article->id;
        $this->date_article = $article->date_article;
        $this->categories = Category::where('type', 'article')->get();
    }

    #[On('newMedia')]
    public function setPoster($media_id): void
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        if($this->modalWidget == null){
            $this->poster = $media->id;

            $this->poster_url = $media->getUrlThumbnail();
            $this->dispatch('updatePoster', $this->poster_url);
        }else {

            $this->dispatch('updatePoster', $media->getUrl());
        }
    }

    #[On('setMedia')]
    public function setPoster_($media_id): void
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        if($this->modalWidget == null){
            $this->poster = $media->id;

            $this->poster_url = $media->getUrlThumbnail();
            $this->dispatch('updatePoster', $this->poster_url);
        }else {

            $this->dispatch('updatePoster', $media->getUrl());
        }
    }

    public function store(): void
    {
        $this->authorize('create articles');
        $validated = $this->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'poster' => 'required|exists:media,id',
            'resume' => 'nullable',
            'slug_' => 'nullable',
            'content_description' => 'nullable',
            'is_featured' => 'nullable|boolean',
            'is_private' => 'nullable|boolean',
            'date_article' => 'nullable|date',
        ]);
        try {
            DB::beginTransaction();
            $this->author = auth()->user()->id;
            $old_values = Article::find($this->article_id)->toArray();
            $validated['slug'] = $this->slug_ ?? str_replace(' ', '-', $validated['title']);
            $validated['tags'] = json_encode($this->tags) ?? json_encode([]);
            $validated['content_keywords'] = json_encode($this->content_keywords) ?? json_encode([]);
            $validated['author_id'] = auth()->user()->id;
            $article = Article::updateOrCreate(['id' => $this->article_id], $validated);
            $article->is_published = false;
            $article->save();

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Article Modifié', 'message' => 'Article modifié avec succès.']);
            AuditService::log("MODIFICATION D'UN ARTICLE", json_encode($old_values), json_encode($article->toArray()), "Modification d'article ".$article->title);
            DB::commit();
            $userpublisher = User::permission('publish articles')->where('is_active', 1)->get();

            // foreach ($userpublisher as $key => $us) {
            //     Mail::to($us->email)->send(new ArticleMail($article));
            // }
            $this->dispatch('new-article', $article->id);
            $this->redirectRoute('articles.index');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de la modification de l'article | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.articles.edit');
    }
}
