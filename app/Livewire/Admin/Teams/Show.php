<?php

namespace App\Livewire\Admin\Teams;

use App\Models\Media;
use App\Models\Team;
use Livewire\Component;

class Show extends Component
{
    public $lastname;

    public $firstname;

    public $title;

    public $avatar;

    public $avatar_url;

    public $facebook_link;

    public $tweeter_link;

    public $linkedin_link;

    public $team;

    public function mount($id)
    {

        $this->authorize('view teams');
        $team = Team::find($id);
        if ($team === null) {
            abort(404);
        }
        $this->team = $team;
        $this->title = $team->title;
        $this->lastname = $team->lastname;
        $this->firstname = $team->firstname;
        $this->avatar = $team->avatar;
        $this->facebook_link = $team->facebook_link;
        $this->tweeter_link = $team->tweeter_link;
        $this->linkedin_link = $team->linkedin_link;
        if ($this->avatar !== null) {
            $media = Media::find($this->avatar);
            $this->avatar_url = $media->getUrlThumbnail();
        }
    }

    public function render()
    {
        return view('livewire.admin.teams.show');
    }
}
