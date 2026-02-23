<?php

namespace App\Livewire\Admin\Resultats;

use App\Models\Resultat;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Resultats extends Component
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
        $this->authorize('list resultats');
        AuditService::log('AFFICHAGE DES LISTES DE RESULTATS D\'ELECTIONS', null, null, 'Liste des activités');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete resultats');
        try {
            DB::beginTransaction();
            $resultat = Resultat::find($id);
            if ($resultat === null) {
                session()->flash('error', 'Résultat introuvable');

                return;
            }
            $resultat->is_deleted = true;
            $resultat->save();
            //ajouter un audit
            AuditService::log("SUPPRESSION D'UN RESULTAT", null, null, 'Résultat supprimé : ' . $resultat->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('resultat-deleted');
            session()->flash('success', 'Résultat supprimé avec succes');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression du résultat');
            AuditService::logError('Suppression | Erreur lors de la suppression du résultats | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

        public function publishResultat($resultat_id)
    {
        $this->authorize('publish resultats');
        try {
            DB::beginTransaction();
            $resultat = Resultat::find($resultat_id);
            if ($resultat === null) {
                session()->flash('error', 'Résultat introuvable');

                return;
            }
            $resultat->is_published = true;
            $resultat->save();
            // ajouter un audit
            AuditService::log("PUBLICATION D'UN RESULTAT", null, null, 'Résultat publiée : ' . $resultat->title);
            DB::commit();
            session()->flash('success', 'Résultat publié avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la publication du résultat');
            AuditService::logError('Publication | Erreur lors de la publication de l\'élection | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function archiveResultat($resultat_id)
    {
        $this->authorize('archive resultats');
        try {
            DB::beginTransaction();
            $resultat = Resultat::find($resultat_id);
            if ($resultat === null) {
                session()->flash('error', 'Résultat introuvable');

                return;
            }
            $resultat->is_archive = true;
            $resultat->save();
            // ajouter un audit
            AuditService::log("ARCHIVAGE D'UN RESULTAT", null, null, 'Résultat archivée : ' . $resultat->title);
            DB::commit();
            session()->flash('success', 'Résultat archivé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'archivage du résultat');
            AuditService::logError('Archivage | Erreur lors de l\'archivage de l\'élection | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishResultat($resultat_id)
    {
        $this->authorize('unpublish resultats');
        try {
            DB::beginTransaction();
            $resultat = Resultat::find($resultat_id);
            if ($resultat === null) {
                session()->flash('error', 'Résultat introuvable');

                return;
            }
            $resultat->is_published = false;
            $resultat->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UN RESULTAT", null, null, 'Résultat desactivée : ' . $resultat->title);
            DB::commit();
            session()->flash('success', 'Résultat desactivée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la desactivation du résultat');
            AuditService::logError('Desactivation | Erreur lors de la desactivation de l\'élection | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $resultats = Resultat::where('is_deleted', false)->where('is_archive', false)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $terms = explode(' ', $this->search);
            $query = Resultat::where('is_deleted', false)->where('is_archive', false);
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'LIKE', "%{$term}%")
                        ->orWhere('url', 'LIKE', "%{$term}%");
                });
            }
            $resultats = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }
        return view('livewire.admin.resultats.resultats', ['resultats' => $resultats]);
    }
}
