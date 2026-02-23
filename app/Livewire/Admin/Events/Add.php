<?php

namespace App\Livewire\Admin\Events;

use App\Models\Category;
use App\Models\Event;
use App\Models\Media;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

use Livewire\Component;

class Add extends Component
{
    public $event_name;

    public $place;

    public $event_date;

    public $event_start;

    public $date_debut;

    public $date_fin;

    public $heure_debut;

    public $heure_fin;

    public $event_end;

    public $event_description;

    public $author;

    public $category;

    public $categories = [];

    public $poster;

    public $poster_url;

    public $modalWidget;

    public function mount()
    {

        $this->authorize('create events');
        $this->categories = Category::where('type', 'Event')->get();
    }

    #[On('newMedia')]
    public function setPoster($media_id): void
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }

        if ($this->modalWidget == null) {
            $this->poster = $media->id;

            $this->poster_url = $media->getUrlThumbnail();
            $this->dispatch('updatePoster', $this->poster_url);
        } else {

            $this->dispatch('updatePoster', $media->getUrl());
        }
    }

    #[On('setMedia')]
    public function setPoster_($media_id): void
    {
        $media = Media::find($media_id);
        if ($media === null) {
            session()->flash('error', 'Media introuvable');

            return;
        }

        if ($this->modalWidget == null) {
            $this->poster = $media->id;

            $this->poster_url = $media->getUrlThumbnail();
            $this->dispatch('updatePoster', $this->poster_url);
        } else {

            $this->dispatch('updatePoster', $media->getUrl());
        }
    }

    public function store()
    {
        $this->authorize('create events');
        $validated = $this->validate([
            'event_name' => 'required|string',
            'place' => 'required|string',
            'event_description' => 'nullable',
            'event_date' => 'nullable|date',
            'date_debut' => 'required|date_format:Y-m-d',
            'heure_debut' => 'required|date_format:H:i',
            'category' => 'required|exists:categories,id',
            'poster' => 'required|exists:media,id',
        ]);
        try {
            DB::beginTransaction();
            $this->author = auth()->user()->id;
            $validated['slug'] = str_replace(' ', '-', $validated['event_name']);
            $validated['event_start'] = $validated['date_debut'] . ' ' . $validated['heure_debut'];

            if ($this->date_fin && $this->heure_fin) {
                $validated['event_end'] = $this->date_fin . ' ' . $this->heure_fin;
            } else {
                $validated['event_end'] = null;
            }
            unset($validated['date_debut']);
            unset($validated['heure_debut']);
            $validated['event_description'] = $this->event_description;
            $validated['author'] = $this->author;
            $event = Event::create($validated);

            $this->reset(['event_name', 'place', 'event_description', 'category', 'event_date', 'date_debut', 'heure_debut', 'date_fin', 'heure_fin']);
            $this->dispatch('resetEditors');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Evènement créé avec succès.']);
            AuditService::log("CREATION D'UN EVENEMENT", null, json_encode($event->toArray()), "Creation d'évènement " . $event->event_name);
            DB::commit();
            $this->dispatch('new-event', $event->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de l'évènement | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.events.add');
    }
}
