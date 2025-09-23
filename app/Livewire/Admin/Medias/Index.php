<?php

namespace App\Livewire\Admin\Medias;

use App\Models\Media;
use App\Services\AuditService;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $confirm_delete;

    public $selected;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    #[Validate(['photos.*' => 'image|max:1024|mimes:jpeg,jpg,png'])]
    public $photos = [];

    public function mount(Media $media)
    {
        $this->authorize('list medias');
        AuditService::log('AFFICHAGE DES MEDIAS', null, null, 'Liste des medias');

    }

    public function removePhoto($key)
    {
        $this->photos = collect($this->photos)->reject(function ($value, $index) use ($key) {
            return $index == $key;
        });
    }

    public function deleteMedia($media_id)
    {
        $this->authorize('delete medias');
        try {
            DB::beginTransaction();
            $media = Media::find($media_id);
            if ($media === null) {
                session()->flash('error', 'Media introuvable');

                return;
            }
            $media->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE MEDIA", null, null, 'Media supprime : '.$media->label);
            DB::commit();
            session()->flash('success', 'Media supprime avec succès');
            $this->confirm_delete = null;
            $this->dispatch('media-deleted');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la suppression de la media');
            AuditService::logError('Suppression | Erreur lors de la suppression de la media | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function save()
    {
        $this->authorize('create medias');
        try {
            DB::beginTransaction();
            $count = 0;
            foreach ($this->photos as $photo) {
                $saved = FileService::uploadFile($photo, 'medias');
                $count++;
            }

            DB::commit();
            session()->flash('success', $count.' média(s) ajouté(s) avec succès.');
            $this->reset();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'ajout des médias.');
            AuditService::logError('Ajout | Erreur lors de l\'ajout de la média | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function dispatchEvent($event, $media_id)
    {

        $this->selected = Media::find($media_id);
    }

    public function render()
    {
        if ($this->search == '') {

            $medias = Media::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $medias = Media::where('type', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.medias.index', ['medias' => $medias]);
    }
}
