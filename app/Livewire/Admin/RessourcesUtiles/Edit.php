<?php

namespace App\Livewire\Admin\RessourcesUtiles;

use App\Models\Media;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Services\FileService;
use Livewire\WithFileUploads;
use App\Services\AuditService;
use App\Models\RessourcesUtile;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    use WithFileUploads;

    public $name;

    public $description;

    public $doc_id;

    public $categorie_id;

    public $doc_type;

    public $doc_size;

    public $doc_path;

    public $attached_file_;

    public $categories = [];

    public $ressourceUtile;

    public $author;

    public $date_creation;

    public $uploadProgress = 0;

    public function mount($id)
    {
        $this->authorize('edit documentation');
        $this->categories = Category::where('type', 'Documentation')->get();
        $ressourceUtile = RessourcesUtile::where('id', $id)->first();

        if ($ressourceUtile == null) {
            abort(404);
        }
        $this->ressourceUtile = $ressourceUtile;
        $this->name = $ressourceUtile->name;
        $this->description = $ressourceUtile->description;
        $this->categorie_id = $ressourceUtile->categorie_id;
        $this->doc_id = $ressourceUtile->doc_id;
        $this->doc_type = $ressourceUtile->doc_type;
        $this->doc_size = $ressourceUtile->doc_size;
        $this->doc_path = $ressourceUtile->doc_path;
        $this->date_creation = $ressourceUtile->date_creation;
    }

    public function updatedAttachedFile()
    {
        $this->uploadProgress = 0; // Réinitialisez la progression à chaque nouveau fichier
        $this->resetErrorBag('attached_file_');
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
        $this->authorize('edit documentation');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'date_creation' => 'nullable|date',
            'categorie_id' => 'required|exists:categories,id',
            'attached_file_' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,bmp,png,zip,rar,xls,xlsx',
        ]);
        try {
            DB::beginTransaction();
            $validated['doc_path'] = $this->doc_path;
            $validated['doc_type'] = $this->doc_type;
            $validated['doc_size'] = $this->doc_size;
            $validated['doc_id'] = $this->doc_id;

            if ($this->attached_file_) {
                $fileupload = FileService::uploadOtherFile($this->attached_file_, 'ressources/');
                $validated['doc_path'] = $fileupload['path'].$fileupload['name'];
                $validated['doc_type'] = $fileupload['type'];
                $validated['doc_size'] = round($fileupload['size'] / 1024, 2);
                $validated['doc_id'] = Str::uuid();
            }

            unset($validated['attached_file_']);

            $ressourceUtile = $this->ressourceUtile;
            $old = $ressourceUtile->toArray();
            $ressourceUtile->update($validated);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Ressource utile modifiée avec succès.']);
            AuditService::log("MODIFICATION D'UNE RESSOURCE UTILE", json_encode($old), json_encode($ressourceUtile->toArray()), 'Modificqtion de la ressource utile '.$ressourceUtile->name);
            DB::commit();
            $this->dispatch('edit-ressource-utile', $ressourceUtile->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Modification | Erreur lors de la modification de la ressource utile | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.ressources-utiles.edit');
    }
}
