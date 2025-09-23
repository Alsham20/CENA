<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use App\Models\Media;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Edit extends Component
{
    public $question;

    public $categories = [];

    public $category;

    public $answer;

    public $is_active = false;

    public $author_id;

    public $order = 0;

    public $faq_id;

    public function mount($faq_id)
    {

        $this->authorize('edit faqs');
        $this->categories = Category::where('type', 'faq')->get();
        $faq = Faq::find($faq_id);
        if ($faq === null) {
            abort(404);
        }

        $this->faq_id = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->is_active = $faq->is_active;
        $this->category = $faq->category_id;
        $this->order = $faq->order;
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
            $old = Faq::find($this->faq_id)->toArray();
            $faq = Faq::updateOrCreate(['id' => $this->faq_id], $validated);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'FAQ modifiée', 'message' => 'FAQ modifiée avec succès.']);
            AuditService::log("MODIFICATION D'UN FAQ", json_encode($old), json_encode($faq->toArray()), 'Modification de FAQ '.$faq->question);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'FAQ Erreur', 'message' => "une erreur s'est produite"]);
            AuditService::logError("Modification | Erreur lors de la modification d'une FAQ | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);

        }

    }

    public function render()
    {
        return view('livewire.admin.faqs.edit');
    }
}
