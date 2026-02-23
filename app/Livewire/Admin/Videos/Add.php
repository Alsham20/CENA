<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Video;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Add extends Component
{
    public $title;

    public $video_description;

    public $date_video;

    public $video_path;

    public $author;

    public $category;

    public $categories = [];

    public $activity;

    public $activities = [];

    public function mount()
    {
        $this->authorize('create videos');
        $this->categories = Category::where('type', 'Video')->get();
        $this->activities = Activity::where('type', 'Video')->get();
    }

    public function store()
    {
        $this->authorize('create videos');
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
            $video = Video::create($validated);

            $this->reset(['title', 'video_description', 'category', 'activity', 'video_path', 'date_video']);
            $this->dispatch('resetEditors');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Vidéo créée avec succès.']);
            AuditService::log("CREATION D'UNE VIDÉO", null, json_encode($video->toArray()), "Creation de vidéo " . $video->title);
            DB::commit();
            $this->dispatch('new-video', $video->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout de la vidéo | " . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.videos.add');
    }
}
