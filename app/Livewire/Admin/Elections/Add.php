<?php

namespace App\Livewire\Admin\Elections;

use App\Models\Category;
use App\Models\Election;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Add extends Component
{
    public $title;

    public $slug_;

    public $year;

    public $date_election;

    public $description;

    public $category;

    public $categories = [];

    public $is_featured = false;

    public $author;

    public function mount()
    {
        $this->authorize('create elections');
        $this->categories = Category::where('type', 'Election')->get();
    }

    public function store()
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
            $validated['author_id'] = $this->author;
            $validated['slug'] = $this->slug_ ?? str_replace(' ', '-', $validated['title']);

            $election = Election::create($validated);
            $this->reset(['title', 'description', 'year', 'date_election', 'category']);
            $this->dispatch('resetEditors');
            //session()->flash('success', 'Election ajoutée avec succès.');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Election créée avec succès.']);

            AuditService::log("CREATION D'UNE ELECTION", null, null, 'Creation de élection ' . $election->title);
            DB::commit();
            $this->dispatch('new-election', $election->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            //$this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de la election | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.elections.add');
    }
}
