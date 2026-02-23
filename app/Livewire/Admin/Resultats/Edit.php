<?php

namespace App\Livewire\Admin\Resultats;

use App\Models\Election;
use App\Models\Resultat;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $title;

    public $url;

    public $zone;

    public $date_resultat;

    public $slug_;

    public $election_id;

    public $author;

    public $elections = [];

    public $resultat;

    public function mount($id)
    {
        $this->authorize('edit resultats');
        $this->elections = Election::all();
        $resultat = Resultat::find($id);
        if ($resultat === null) {
            abort(404);
        }
        $this->title = $resultat->title;
        $this->zone = $resultat->zone;
        $this->url = $resultat->url;
        $this->date_resultat = ($resultat->date_resultat) ? Carbon::parse($resultat->date_resultat)->format('Y-m-d') : '';
        $this->election_id = $resultat->election_id;
        $this->author = $resultat->author;
        $this->resultat = $resultat;
    }

    public function store()
    {
        $this->authorize('create resultats');
        $validated = $this->validate([
            'title' => 'required|string',
            'url' => 'required|string',
            'zone' => 'nullable',
            'date_resultat' => 'nullable|date',
            'election_id' => 'required|exists:elections,id',
        ]);
        try {
            DB::beginTransaction();
            $this->author = auth()->user()->id;

            $validated['author_id'] = $this->author;
            $validated['slug'] = $this->slug_ ?? str_replace(' ', '-', $validated['title']);

            $resultat = $this->resultat;
            $resultat->update($validated);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Activité modifié avec succès.']);

            AuditService::log("MODIFICATION D'UN RESULTAT", null, null, "Modification du résultat " . $resultat->title);
            DB::commit();
            $this->dispatch('edit-resultat', $resultat->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Modification | Erreur lors de la modification du resultat | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.resultats.edit');
    }
}
