<?php

namespace App\Livewire\Admin\Activities;

use App\Models\Activity;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $label;

    public $type;

    public $types = ['FAQ', 'Page', 'Article', 'Video', 'Event', 'Documentation', 'Abonne'];

    public $parent;

    protected $author;

    public $activity;

    public $activities;

    public function mount($activity_id)
    {
        $this->authorize('edit activities');
        $activity = Activity::find($activity_id);
        if ($activity === null) {
            abort(404);
        }
        $this->label = $activity->label;
        $this->type = $activity->type;
        $this->author = $activity->author;
        $this->activity = $activity;

        $this->activities = Activity::all();
    }

    public function store()
    {
        $this->authorize('edit activities');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'label' => 'required|min:3',
            'type' => 'required|in:' . implode(',', $this->types),
        ]);
        try {
            DB::beginTransaction();

            $activity = $this->activity;
            $old = $activity->toArray();
            $activity->update($validated);

            DB::commit();
            // session()->flash('success', "Activité modifier avec succès.");
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Activité modifiée avec succès.']);

            AuditService::log("MODIFICATION D'UNE ACTIVITÉ", json_encode($old), json_encode($activity->toArray()), 'Modification d\' activité ' . $activity->label);
        } catch (\Throwable $th) {
            DB::rollBack();
            // session()->flash('error', $th->getMessage());
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Modification | Erreur lors de la modification de l\'activité | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.activities.edit');
    }
}
