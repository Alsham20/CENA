<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Pages;

use App\Models\Category;
use App\Models\Media;
use App\Models\Page;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
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

    public $page_id;

    public $categories = [];

    public $modalWidget;

    public function mount($page_id): void
    {
        $this->authorize('edit pages');
        $page = Page::find($page_id);
        if ($page === null) {
            abort(404);
        }
        $this->title = $page->title;
        $this->content = $page->content;
        // $this->author = $page->author;
        $this->category = $page->category;
        $this->poster = $page->poster;

        if ($this->poster !== null) {
            $media = Media::find($this->poster);
            $this->poster_url = $media->getUrlThumbnail();
        }
        $this->resume = $page->resume;
        $this->tags = json_decode($page->tags);
        $this->slug_ = $page->slug;
        $this->content_keywords = json_decode($page->content_keywords);
        $this->content_description = $page->content_description;
        $this->page_id = $page->id;

        $this->categories = Category::where('type', 'page')->get();
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
        $this->authorize('create pages');
        $validated = $this->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'poster' => 'required|exists:media,id',
            'resume' => 'nullable',
            'slug_' => 'nullable',
            'content_description' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $this->author = auth()->user()->id;

            $validated['slug'] = $this->slug_ ?? str_replace(' ', '-', $validated['title']);
            $validated['tags'] = json_encode($this->tags) ?? json_encode([]);
            $validated['content_keywords'] = json_encode($this->content_keywords) ?? json_encode([]);
            $validated['author_id'] = auth()->user()->id;
            $old = Page::find($this->page_id)->toArray();
            $page = Page::updateOrCreate(['id' => $this->page_id], $validated);
            $page->is_published = false;
            $page->save();

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Page Modifiée', 'message' => 'Page modifiée avec succès.']);
            AuditService::log("MODIFICATION D'UN Page", json_encode($old), json_encode($validated), "Modification d'page ".$page->title);
            DB::commit();
            $this->dispatch('new-page', $page->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de la modification de l'page | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.edit');
    }
}
