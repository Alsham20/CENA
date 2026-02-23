<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Video;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $title;

    public $video_description;

    public $date_video;

    public $video_path;

    public $video;

    public $author;

    public $category;

    public $categories = [];

    public $activity;

    public $activities = [];

    public function mount($id)
    {
        $this->authorize('edit videos');
        $video = Video::find($id);
        if ($video === null) {
            abort(404);
        }
        $this->video = $video;
        $this->title = $video->title;
        $this->video_description = $video->video_description;
        $this->video_path = $video->video_path;
        $this->date_video = ($video->date_video)  ? Carbon::parse($video->date_video)->format('Y-m-d') : '';
        $this->category = $video->category;
        $this->activity = $video->activity;
        $this->categories = Category::where('type', 'Video')->get();
        $this->activities = Activity::where('type', 'Video')->get();
    }
    public function render()
    {
        return view('livewire.admin.videos.show');
    }
}
