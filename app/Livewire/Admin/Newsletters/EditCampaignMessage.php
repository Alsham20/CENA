<?php

namespace App\Livewire\Admin\Newsletters;

use App\Models\Media;
use Livewire\Component;
use App\Models\NewsLetter;
use Livewire\Attributes\On;
use App\Services\AuditService;
use App\Models\NewsletterAbonne;
use App\Models\NewsletterMessage;
use Illuminate\Support\Facades\DB;

class EditCampaignMessage extends Component
{
    public $categories = [];

    public $categorie;

    public $name;

    public $message;

    public $object;

    public $campaign;

    public function mount($id)
    {

        $this->authorize('edit campaigns');
        $campaign = NewsletterMessage::find($id);
        if ($campaign === null) {
            abort(404);
        }
        $this->campaign = $campaign;
        $this->name = $campaign->name;
        $this->object = $campaign->object;
        $this->message = $campaign->message;
        if ($campaign->categorie === null) {
            $this->categorie = -1;
        } else {
            $this->categorie = $campaign->categorie;
        }

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

    public function update()
    {
        $this->authorize('edit campaigns');
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
            NewsletterAbonne::where('message_id', $this->campaign->id)->delete();
            $message = NewsletterMessage::where('id', $this->campaign->id)->update(['name' => $validated['name'], 'object' => $validated['object'], 'message' => $validated['message'], 'categorie_abonne_id' => $cat, 'status' => 0]);
            foreach ($abonnes as $abonne) {
                NewsletterAbonne::create(['message_id' => $this->campaign->id, 'abonne_id' => $abonne->id]);
            }

            // $this->reset(['categorie','name','message','object']);
            // $this->dispatch('resetEditors');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Campagne modifiée avec succès.']);
            AuditService::log("MODIFICATION D'UNE CAMPAGNE", null, null, 'Modification de campagne');
            DB::commit();
            $this->dispatch('edit-campaign');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Modification | Erreur lors de la modification des campagnes | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.newsletters.edit-campaign-message');
    }
}
