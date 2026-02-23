<?php

namespace App\Livewire\Admin\Activities;

use App\Models\Activity;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Add extends Component
{
    public $label;

    public $type;

    public $types = ['FAQ', 'Page', 'Article', 'Video', 'Event', 'Documentation', 'Abonne'];

    public $author;

    public $activities;

    public function mount()
    {
        $this->activities = Activity::all();
    }

    public function store()
    {
        $this->authorize('create activities');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'label' => 'required|min:3',
            'type' => 'required|in:' . implode(',', $this->types),
            'author' => 'nullable|exists:users,id',
        ]);
        try {
            DB::beginTransaction();

            $activity = Activity::create($validated);
            DB::commit();
            $this->reset(['label', 'type']);
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Activité Créée', 'message' => 'Activité créée avec succès.']);
            AuditService::log("CREATION D'UNE ACTIVITÉ", null, json_encode($activity->toArray()), 'Creation d\'activité ' . $activity->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            // session()->flash('error', $th->getMessage());
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);

            AuditService::logError("Creation | Erreur lors de l'ajout de l'activité | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.activities.add');
    }
}
