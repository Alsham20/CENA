<?php

namespace App\Livewire\Admin\Activities;

use App\Models\Activity;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Activities extends Component
{
    use WithPagination;

    public $confirm_delete;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public $types = ['FAQ', 'Page', 'Article', 'Video', 'Event', 'Documentation', 'Abonne'];

    public $type;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function mount()
    {
        $this->authorize('list activities');
        AuditService::log('AFFICHAGE DES ACTIVITÉS', null, null, 'Liste des activités');

    }

    #[On('deleteActivity')]
    public function deleteActivity($activity_id)
    {
        $this->authorize('delete activities');
        try {
            DB::beginTransaction();
            $activity = Activity::find($activity_id);
            if ($activity === null) {
                session()->flash('error', 'Activité introuvable');

                return;
            }
            // $this->deleteChildren($activity);
            $activity->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE ACTIVITÉ", null, null, 'Categorie supprimée : '.$activity->label);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('activity-deleted');
            session()->flash('success', 'Activité supprimée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression de l\'activité');
            AuditService::logError('Suppression | Erreur lors de la suppression de l\'activité | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        if ($this->search == '') {
            $activities = Activity::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $activities = Activity::where('label', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->type != '') {
            $activities->where('type', $this->type);
        }
        $activities = $activities->paginate($this->perPage);

        return view('livewire.admin.activities.activities', ['activities' => $activities]);
    }

    private function deleteChildren($activity)
    {
        // Récupérer toutes les catégories enfants
        $childActivities = Activity::where('parent', $activity->id)->get();

        // Supprimer récursivement chaque enfant
        foreach ($childActivities as $childActivity) {
            $this->deleteChildren($childActivity); // Appel récursif
            $childActivity->delete(); // Supprimer la catégorie enfant
        }
    }
}
