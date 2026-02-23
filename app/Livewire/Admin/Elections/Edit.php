<?php

namespace App\Livewire\Admin\Elections;

use App\Models\Category;
use App\Models\Election;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{

    public $title;

    public $description;

    public $slug_;

    public $year;

    public $date_election;

    public $author;

    public $is_featured = false;

    public $election;

    public $election_id;

    public $category;

    public $categories = [];


    public function mount($id)
    {
        $this->authorize('edit elections');
        $election = Election::find($id);
        if ($election === null) {
            abort(404);
        }
        $this->election = $election;
        $this->title = $election->title;
        $this->year = $election->year;
        $this->slug_ = $election->slug;
        $this->description = $election->description;
        $this->author = $election->author;
        $this->category = $election->category;
        $this->election_id = $election->id;
        $this->date_election = ($election->date_election) ? Carbon::parse($election->date_election)->format('Y-m-d') : '';
        $this->categories = Category::where(['type' => 'Election'])->get();
    }

    public function store(): void
    {
        $this->authorize('create elections');
        $validated = $this->validate([
            'title' => 'required|string',
            'year' => 'nullable|string',
            'description' => 'nullable',
            'date_election' => 'nullable|date',
            'category' => 'required|exists:categories,id',
        ]);
        try {
            DB::beginTransaction();
            $this->author = auth()->user()->id;

            $validated['slug'] = $this->slug_ ?? str_replace(' ', '-', $validated['title']);
            $validated['author_id'] = $this->author;
            $election = $this->election;
            $election->update($validated);

            //session()->flash('success', 'Election modifiée avec succès.');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Election modifiée avec succès.']);

            AuditService::log("MODIFICATION D'UNE ELECTION", null, null, 'Modification d\'élection ' . $election->title);
            DB::commit();
            $this->dispatch('edit-election', $election->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);

            AuditService::logError("Modification | Erreur lors de la modification de l'élection | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.elections.edit');
    }
}
