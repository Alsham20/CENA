<?php

namespace App\Livewire\Admin\Resultats;

use App\Models\Election;
use App\Models\Resultat;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
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
        $this->authorize('view resultats');
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

    public function render()
    {
        return view('livewire.admin.resultats.show');
    }
}
