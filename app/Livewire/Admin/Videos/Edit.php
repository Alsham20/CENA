<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Video;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
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

    public function update()
    {
        $this->authorize('edit videos');
        $validated = $this->validate([
            'title' => 'required|string',
            'video_description' => 'nullable',
            'video_path' => 'required|string',
            'date_video' => 'nullable|date',
            'category' => 'required|exists:categories,id',
            'activity' => 'required|exists:activities,id',
        ]);
        try {
            DB::beginTransaction();
            $this->author = auth()->user()->id;

            $validated['video_description'] = $this->video_description;
            $validated['author'] = $this->author;
            $video = $this->video;
            $old = $video->toArray();
            $video->update($validated);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Modification', 'message' => 'Vidéo modifiée avec succès.']);
            AuditService::log("MODIFICATION D'UNE VIDÉO", json_encode($old), json_encode($video->toArray()), "Modification de la vidéo " . $video->title);
            DB::commit();
            $this->dispatch('edit-video', $video->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Modification | Erreur lors de la modification de la vidéo | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.videos.edit');
    }
}
