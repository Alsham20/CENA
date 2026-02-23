<?php

namespace App\Livewire\Admin\Elections;

use App\Models\Category;
use App\Models\Election;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
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
        $this->authorize('view elections');
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

    public function render()
    {
        return view('livewire.admin.elections.show');
    }
}
