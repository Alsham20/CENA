<?php

namespace App\Livewire\Admin\Newsletters;

use App\Models\Media;
use Livewire\Component;
use App\Models\Category;
use App\Models\NewsLetter;
use Livewire\Attributes\On;
use App\Services\AuditService;
use App\Models\NewsletterAbonne;
use App\Models\NewsletterMessage;
use Illuminate\Support\Facades\DB;

class AddCampaignMessage extends Component
{
    public $categories = [];

    public $categorie;

    public $name;

    public $message;

    public $object;

    public function mount()
    {
        $this->categories = Category::where('type', 'abonne')->get();
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
        $this->authorize('create campaigns');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'name' => 'required|string',
            'object' => 'required|string',
            'categorie' => 'required|integer',
            'message' => 'required|string',
        ]);
        try {
            DB::beginTransaction();

            // dd($fileupload);
            if ($this->categorie == -1) {
                $cat = null;
                $abonnes = NewsLetter::whereNull('categorie_abonne_id')->where('is_active', 1)->get();
            } else {
                $cat = $this->categorie;
                $abonnes = NewsLetter::where('categorie_abonne_id', $this->categorie)->where('is_active', 1)->get();
            }
            $message = NewsletterMessage::create(['name' => $validated['name'], 'object' => $validated['object'], 'message' => $validated['message'], 'categorie_abonne_id' => $cat]);
            foreach ($abonnes as $abonne) {
                NewsletterAbonne::create(['message_id' => $message->id, 'abonne_id' => $abonne->id]);
            }

            $this->reset(['categorie', 'name', 'message', 'object']);
            $this->dispatch('resetEditors');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Campagne créée avec succès.']);
            AuditService::log("CREATION D'UNE CAMPAGNE", null, null, 'Création de campagne');
            DB::commit();
            $this->dispatch('new-campaign');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Création | Erreur lors de la création des campagnes | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.newsletters.add-campaign-message');
    }
}
