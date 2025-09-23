<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Category;
use App\Models\Media;
use App\Models\Page;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

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

    public $categories = [];

    public $modalWidget;

    public function mount()
    {
        $this->authorize('create pages');
        $this->categories = Category::where('type', 'Page')->get();
        $this->dispatch('pageAdded');
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

    public function store()
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
            $article = Page::create($validated);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'message' => 'Page ajoutée avec succès.', 'title' => 'Page ajoutée']);
            $this->reset(['title', 'content', 'category', 'resume', 'tags', 'slug_', 'content_keywords', 'content_description']);
            $this->dispatch('resetEditors');
            AuditService::log("CREATION D'UNE PAGE", null, json_encode($article->toArray()), 'Creation de page '.$article->title);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de la page | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.add');
    }

    public function dehydrate()
    {
        $this->dispatch('pageAdded');
    }
}
