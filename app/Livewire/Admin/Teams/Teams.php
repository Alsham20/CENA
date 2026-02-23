<?php

namespace App\Livewire\Admin\Teams;

use App\Models\Team;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Teams extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $confirm_delete;

    public $status;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function mount()
    {
        $this->authorize('list teams');
        AuditService::log('AFFICHAGE DES MEMBRES DU CONSEIL', null, null, 'Liste des membres d\'équipe');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete teams');
        try {
            DB::beginTransaction();
            $team = Team::find($id);
            if ($team === null) {
                session()->flash('error', 'Equipe introuvable');

                return;
            }
            $team->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN MEMBRE", null, null, 'Membre supprimé : '.$team->firstname.' '.$team->lastname);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('team-deleted');
            session()->flash('success', 'Membre supprimé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression du membre');
            AuditService::logError('Suppression | Erreur lors de la suppression du membre | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {
        if ($this->search == '') {
            $teams = Team::orderBy('order', 'asc')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = Team::orderBy('order', 'asc');
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('lastname', 'LIKE', "%{$term}%")
                        ->orWhere('firstname', 'LIKE', "%{$term}%")
                        ->orWhere('title', 'LIKE', "%{$term}%");
                });
            }
            $teams = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->status != '') {
            $teams->where('is_private', $this->status);
        }
        $teams = $teams->paginate($this->perPage);

        return view('livewire.admin.teams.teams', ['teams' => $teams]);
    }
}
