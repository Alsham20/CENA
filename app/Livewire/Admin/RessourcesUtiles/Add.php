<?php

namespace App\Livewire\Admin\RessourcesUtiles;

use App\Models\Category;
use App\Models\RessourcesUtile;
use App\Services\AuditService;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Media;

class Add extends Component
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

    public $author;

    public $date_creation;

    public $uploadProgress = 0; // Ajoutez cette propriété pour suivre la progression


    public function mount()
    {
        $this->authorize('create documentation');
        $this->categories = Category::where('type', 'Documentation')->get();
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
    public function store()
    {
        $this->authorize('create documentation');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'name' => 'required|string',
            'date_creation' => 'nullable|date',
            'categorie_id' => 'required|exists:categories,id',
            'attached_file_' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,bmp,png,zip,rar,xls,xlsx|max:1024000',
        ]);

        try {
            DB::beginTransaction();

            $fileupload = FileService::uploadOtherFile($this->attached_file_, 'ressources/');

            unset($validated['attached_file_']);

            $validated['doc_path'] = $fileupload['path'].$fileupload['name'];
            $validated['doc_type'] = $fileupload['type'];
            $validated['doc_size'] = round($fileupload['size'] / 1024, 2);
            $validated['doc_id'] = Str::uuid();
            $ressourceUtile = RessourcesUtile::create($validated);

            $this->reset(['name', 'attached_file_', 'doc_path', 'categorie_id']);
            $this->dispatch('resetEditors');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Documentation créée avec succès.']);
            AuditService::log("CREATION D'UNE DOCUMENTATION", null, json_encode($ressourceUtile->toArray()), 'Creation de la documentation '.$ressourceUtile->name);
            DB::commit();
            $this->dispatch('new-ressource-utile', $ressourceUtile->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de la documentation | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.ressources-utiles.add');
    }
}
