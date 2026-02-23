<?php

namespace App\Livewire\Admin\Events;

use App\Models\Category;
use App\Models\Event;
use App\Models\Media;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
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
        $this->authorize('view events');
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

    public function render()
    {
        return view('livewire.admin.events.show');
    }
}
