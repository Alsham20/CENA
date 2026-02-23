<?php

namespace App\Livewire\Admin\Resultats;

use App\Models\Election;
use App\Models\Resultat;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Add extends Component
{
    public $title;

    public $slug_;

    public $url;

    public $zone;

    public $date_resultat;

    public $election_id;

    public $author;

    public $elections = [];

    public function mount()
    {
        $this->authorize('create resultats');
        $this->elections = Election::all();
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

            $resultat = Resultat::create($validated);
            $this->reset(['title', 'url', 'zone', 'date_resultat', 'election_id']);
            //session()->flash('success', 'Résultat ajouté avec succès.');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Résultat créé avec succès.']);

            AuditService::log("CREATION D'UN RESULTAT", null, null, "Creation du résultat " . $resultat->title);
            DB::commit();
            $this->dispatch('new-resultat', $resultat->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            //$this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);

            AuditService::logError("Creation | Erreur lors de l'ajout du résultat | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.resultats.add');
    }
}
