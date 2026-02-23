<?php

namespace App\Livewire\Admin\Elections;

use App\Models\Election;
use App\Models\Resultat;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Elections extends Component
{
    use WithPagination;
    //pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $confirm_delete;

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
        $this->authorize('list elections');
        AuditService::log('AFFICHAGE DES ELECTIONS', null, null, 'Liste des elections');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete elections');
        try {
            DB::beginTransaction();
            $election = Election::find($id);
            if ($election === null) {
                session()->flash('error', 'Election introuvable');

                return;
            }
            $election->is_deleted = true;
            $election->save();
            //ajouter un audit
            AuditService::log("SUPPRESSION D'UNE ELECTION", null, null, 'Election supprimée : ' . $election->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('election-deleted');
            session()->flash('success', 'Election supprimée avec succes');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression des elections');
            AuditService::logError('Suppression | Erreur lors de la suppression des elections | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function publishElection($election_id)
    {
        $this->authorize('publish elections');
        try {
            DB::beginTransaction();
            $election = Election::find($election_id);
            if ($election === null) {
                session()->flash('error', 'Election introuvable');

                return;
            }
            $election->is_published = true;
            $election->save();
            // ajouter un audit
            AuditService::log("PUBLICATION D'UNE ELECTION", null, null, 'Election publiée : ' . $election->title);
            DB::commit();
            session()->flash('success', 'Election publiée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la publication de l\'élection');
            AuditService::logError('Publication | Erreur lors de la publication de l\'élection | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function archiveElection($election_id)
    {
        $this->authorize('archive elections');
        try {
            DB::beginTransaction();
            $election = Election::find($election_id);
            if ($election === null) {
                session()->flash('error', 'Election introuvable');

                return;
            }
            $election->is_archive = true;
            $election->save();
            // ajouter un audit
            AuditService::log("ARCHIVAGE D'UNE ELECTION", null, null, 'Election archivée : ' . $election->title);
            DB::commit();
            session()->flash('success', 'Election archivée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'archivage de l\'élection');
            AuditService::logError('Archivage | Erreur lors de l\'archivage de l\'élection | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishElection($election_id)
    {
        $this->authorize('unpublish elections');
        try {
            DB::beginTransaction();
            $election = Election::find($election_id);
            if ($election === null) {
                session()->flash('error', 'Election introuvable');

                return;
            }
            $election->is_published = false;
            $election->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UNE ELECTION", null, null, 'Election desactivée : ' . $election->title);
            DB::commit();
            session()->flash('success', 'Election desactivée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la desactivation de l\'élection');
            AuditService::logError('Desactivation | Erreur lors de la desactivation de l\'élection | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $elections = Election::where('is_deleted', false)->where('is_archive', false)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $terms = explode(' ', $this->search);
            $query = Election::where('is_deleted', false)->where('is_archive', false);
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%");
                });
            }
            $elections = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }
        return view('livewire.admin.elections.elections', ['elections' => $elections]);
    }
}
