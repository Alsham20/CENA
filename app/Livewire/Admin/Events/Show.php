<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $event_name;

    public $place;

    public $event_start;

    public $date_debut;

    public $date_fin;

    public $heure_debut;

    public $heure_fin;

    public $event_end;

    public $event_description;

    public $event;

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
        $this->event_description = $event->event_description;
        $this->date_debut = ($event->event_start) ? Carbon::parse($event->event_start)->format('Y-m-d') : '';
        $this->heure_debut = ($event->event_start) ? Carbon::parse($event->event_start)->format('H:i') : '';
        $this->date_fin = ($event->event_end) ? Carbon::parse($event->event_end)->format('Y-m-d') : '';
        $this->heure_fin = ($event->event_end) ? Carbon::parse($event->event_end)->format('H:i') : '';
    }

    public function render()
    {
        return view('livewire.admin.events.show');
    }
}
