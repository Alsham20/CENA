<?php

namespace App\Livewire\Admin\Teams;

use App\Models\Media;
use App\Models\Team;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $lastname;

    public $firstname;

    public $title;

    public $fonction;

    public $order;

    public $avatar;

    public $avatar_url;

    public $team;

    public $is_private = false;

    public function mount($id)
    {

        $this->authorize('edit teams');
        $team = Team::find($id);
        if ($team === null) {
            abort(404);
        }
        $this->team = $team;
        $this->title = $team->title;
        $this->fonction = $team->fonction;
        $this->lastname = $team->lastname;
        $this->firstname = $team->firstname;
        $this->order = $team->order;
        $this->avatar = $team->avatar;
        $this->is_private = $team->is_private;
        if ($this->avatar !== null) {
            $media = Media::find($this->avatar);
            $this->avatar_url = $media->getUrlThumbnail();
        }
    }

    #[On('newMedia')]
    public function setAvatar($media_id)
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        $this->avatar = $media->id;
        $this->avatar_url = $media->getUrlThumbnail();
        $this->dispatch('updateAvatar', $this->avatar_url);

    }

    #[On('setMedia')]
    public function setAvatar_($media_id)
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }
        $this->avatar = $media->id;
        $this->avatar_url = $media->getUrlThumbnail();
        $this->dispatch('updateAvatar', $this->avatar_url);

    }

    public function update()
    {
        $this->authorize('edit teams');
        $validated = $this->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'title' => 'required|string',
            'fonction' => 'nullable|string',
            'order' => 'required|integer',
            'avatar' => 'required|exists:media,id',
            'is_private' => 'nullable|boolean',
        ]);
        try {
            DB::beginTransaction();
            // $this->author = auth()->user()->id;

            $team = $this->team;
            $old = $team->toArray();
            $team->update($validated);
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Membre d\'équipe modifié avec succès.']);
            AuditService::log("MODIFICATION D'UNE EQUIPE", json_encode($old), json_encode($team->toArray()), "Modification de l'équipe ".$team->firstname.' '.$team->lastname);
            DB::commit();
            $this->dispatch('edit-team', $team->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Modification | Erreur lors de la modification de l'équipe | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.teams.edit');
    }
}
