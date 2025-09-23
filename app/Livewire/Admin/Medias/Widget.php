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

class Widget extends Component
{
    use WithFileUploads, WithPagination;

    public $selected;

    // pagination
    public $perPage = 15;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    #[Validate('required|image|max:5024|mimes:jpeg,jpg,png')]
    public $photo;

    public function mount()
    {
        $this->authorize('list medias');
        AuditService::log('AFFICHAGE DU WIDGET DES MEDIAS', null, null, 'Liste du widget des medias');
    }

    public function save()
    {
        $this->authorize('create medias');
        try {
            DB::beginTransaction();
            $saved = FileService::uploadFile($this->photo, 'medias');
            $this->dispatch('newMedia', $saved->id);
            DB::commit();
            session()->flash('success', 'Media ajouté avec succès.');
            $this->reset();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'ajout de la media.');
            AuditService::logError('Ajout | Erreur lors de l\'ajout de la media | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function dispatchEvent($event, $media_id)
    {
        $this->dispatch($event, $media_id);
        $this->selected = $media_id;
        session()->flash('success', 'Media sélectionné avec succès.');
    }

    public function render()
    {
        if ($this->search == '') {

            $medias = Media::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $medias = Media::where('type', 'like', '%' . $this->search . '%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.medias.widget', ['medias' => $medias]);
    }
}
