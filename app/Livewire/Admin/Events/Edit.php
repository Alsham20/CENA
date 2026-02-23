<?php

namespace App\Livewire\Admin\Events;

use App\Models\Category;
use App\Models\Event;
use App\Models\Media;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $event_name;

    public $slug_;

    public $place;

    public $event_date;

    public $event_start;

    public $date_debut;

    public $date_fin;

    public $heure_debut;

    public $heure_fin;

    public $event_end;

    public $event_description;

    public $event;

    public $author;

    public $category;

    public $categories = [];

    public $modalWidget;

    public $poster;

    public $poster_url;


    public function mount($id)
    {
        $this->authorize('edit events');
        $event = Event::find($id);
        if ($event === null) {
            abort(404);
        }
        $this->event = $event;
        $this->event_name = $event->event_name;
        $this->place = $event->place;
        $this->slug_ = $event->slug;
        $this->event_description = $event->event_description;
        $this->date_debut = ($event->event_start) ? Carbon::parse($event->event_start)->format('Y-m-d') : '';
        $this->heure_debut = ($event->event_start) ? Carbon::parse($event->event_start)->format('H:i') : '';
        $this->date_fin = ($event->event_end) ? Carbon::parse($event->event_end)->format('Y-m-d') : '';
        $this->heure_fin = ($event->event_end) ? Carbon::parse($event->event_end)->format('H:i') : '';
        $this->event_date = ($event->event_date)  ? Carbon::parse($event->event_date)->format('Y-m-d') : '';
        $this->category = $event->category;
        $this->poster = $event->poster;

        if ($this->poster !== null) {
            $media = Media::find($this->poster);
            $this->poster_url = $media->getUrlThumbnail();
        }
        $this->categories = Category::where('type', 'event')->get();
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

    public function update()
    {
        $this->authorize('edit events');
        $validated = $this->validate([
            'event_name' => 'required|string',
            'slug_' => 'nullable',
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
            $validated['slug'] = $this->slug_ ?? str_replace(' ', '-', $validated['event_name']);
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
            $event = $this->event;
            $old = $event->toArray();
            $event->update($validated);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Evènement modifié avec succès.']);
            AuditService::log("MODIFICATION D'UN EVENEMENT", json_encode($old), json_encode($event->toArray()), "Modification de l'évènement " . $event->event_name);
            DB::commit();
            $this->dispatch('edit-event', $event->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Modification | Erreur lors de la modification de l'évènement | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.events.edit');
    }
}
