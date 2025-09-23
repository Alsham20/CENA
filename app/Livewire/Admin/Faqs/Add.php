<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use App\Models\Media;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;

class Add extends Component
{
    public $question;

    public $categories = [];

    public $category;

    public $answer;

    public $is_active = false;

    public $author_id;

    public $order = 0;

    public function mount()
    {

        $this->authorize('create faqs');
        $this->categories = Category::where('type', 'faq')->get();
    }

    #[On('newMedia')]
    public function setPoster($media_id): void
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        $this->dispatch('updatePoster', $media->getUrl());
    }

    #[On('setMedia')]
    public function setPoster_($media_id): void
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        //$this->poster = $media->id;
        //$this->poster_url = $media->getUrlThumbnail();
        $this->dispatch('updatePoster', $media->getUrl());
    }

    public function store()
    {
        $this->authorize('create faqs');
        $validated = $this->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'required',
            'order' => 'required|numeric',
            'category' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();
            $this->author_id = auth()->user()->id;
            $validated['author_id'] = $this->author_id;
            $validated['category_id'] = $this->category;

            $faq = Faq::create($validated);
            $this->reset(['question', 'answer', 'is_active', 'author_id', 'category', 'order']);
            $this->dispatch('resetEditors');
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'FAQ Creé', 'message' => 'FAQ créé avec succès.']);
            AuditService::log("CREATION D'UN FAQ", null, json_encode($faq->toArray()), "Creation d'FAQ ".$faq->question);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'FAQ Erreur', 'message' => $th->getMessage()]);
            AuditService::logError("Creation | Erreur lors de l'ajout d'une FAQ | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);

        }

    }

    public function render()
    {
        return view('livewire.admin.faqs.add');
    }
}
