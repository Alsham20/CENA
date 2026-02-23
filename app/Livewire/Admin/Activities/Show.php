<?php

namespace App\Livewire\Admin\Activities;

use App\Models\Activity;
use App\Services\AuditService;
use Livewire\Component;

class Show extends Component
{
        public $label;

    public $type;

    public $types = ['FAQ', 'Page', 'Article', 'Video', 'Event', 'Abonne', 'Documentation'];

    public $parent;

    public $author;

    public $activity;

    public $activities;

    public function mount($activity_id)
    {
        $this->authorize('view activities');
        $activity = Activity::find($activity_id);
        if ($activity === null) {
            abort(404);
        }
        $this->label = $activity->label;
        $this->type = $activity->type;
        $this->author = $activity->author;
        $this->activity = $activity;

        $this->activities = Activity::all();

        AuditService::log("AFFICHAGE D'UNE ACTIVITÉ", null, null, 'Affichage de l\'activité '.$activity->label);

    }

    public function render()
    {
        return view('livewire.admin.activities.show');
    }
}
