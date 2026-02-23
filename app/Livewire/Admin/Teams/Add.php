<?php

namespace App\Livewire\Admin\Teams;

use App\Models\Media;
use App\Models\Team;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Add extends Component
{
    public $lastname;

    public $firstname;

    public $title;

    public $order;

    public $avatar;

    public $avatar_url;

    public $facebook_link;

    public $tweeter_link;

    public $linkedin_link;

    public $fonction;

    public $is_private = false;

    public $modalWidget;

    public function mount()
    {

        $this->authorize('create teams');
    }

    #[On('newMedia')]
    public function setAvatar($media_id)
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        if ($this->modalWidget == null) {
            $this->avatar = $media->id;
            $this->avatar_url = $media->getUrlThumbnail();
            $this->dispatch('updateAvatar', $this->avatar_url);
        } else {
            $this->dispatch('updateAvatar', $media->getUrl());
        }
    }

    #[On('setMedia')]
    public function setAvatar_($media_id)
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        if ($this->modalWidget == null) {
            $this->avatar = $media->id;
            $this->avatar_url = $media->getUrlThumbnail();
            $this->dispatch('updateAvatar', $this->avatar_url);
        } else {
            $this->dispatch('updateAvatar', $media->getUrl());
        }
    }

    public function store()
    {

        $this->authorize('create teams');
        $validated = $this->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'title' => 'required|string',
            'fonction' => 'nullable|string',
            'facebook_link' => 'nullable|string',
            'tweeter_link' => 'nullable|string',
            'linkedin_link' => 'nullable|string',
            'order' => 'required|integer',
            'avatar' => 'required|exists:media,id',
            'is_private' => 'nullable|boolean',
        ]);
        try {
            DB::beginTransaction();
            // $this->author = auth()->user()->id;

            $team = Team::create($validated);
            $this->reset(['lastname', 'firstname', 'title', 'fonction', 'facebook_link', 'tweeter_link', 'linkedin_link']);
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Membre du conseil créé avec succès.']);
            AuditService::log("CREATION D'UN MEMBRE", null, json_encode($team->toArray()), "Creation d'un membre " . $team->title);
            DB::commit();
            $this->dispatch('new-team', $team->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de l'équipe | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.teams.add');
    }
}
