<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Activity;
use App\Models\Category;
use App\Models\User;
use App\Models\Video;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Videos extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $category = -1;

    public $categories;

    public $activity = -1;

    public $activities;

    public $type_category;

    public $type_activity;

    public $confirm_delete;

    public $status;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function mount()
    {
        $this->authorize('list videos');
        $this->categories = Category::where('type', 'Video')->get();
        $this->activities = Activity::where('type', 'Video')->get();
        AuditService::log('AFFICHAGE DES VIDÉOS', null, null, 'Liste des vidéos');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete videos');
        try {
            DB::beginTransaction();
            $video = Video::find($id);
            if ($video === null) {
                session()->flash('error', 'Vidéo introuvable');

                return;
            }
            $video->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE VIDÉO", null, null, 'Vidéo supprimée : ' . $video->title);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('video-deleted');
            session()->flash('success', 'Vidéo supprimée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('video-error');
            session()->flash('error', 'Erreur lors de la suppression de la vidéo');
            AuditService::logError('Suppression | Erreur lors de la suppression de la vidéo | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $videos = Video::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = Video::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('title', 'LIKE', "%{$term}%")
                        ->orWhere('video_description', 'LIKE', "%{$term}%");
                });
            }
            $videos = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->category != -1) {
            $videos->where('category', (int) $this->category);
        }

        if ($this->activity != -1) {
            $videos->where('activity', (int) $this->activity);
        }

        if ($this->status != '') {
            $videos->where('is_published', $this->status);
        }

        $videos = $videos->paginate($this->perPage);

        return view('livewire.admin.videos.videos', ['videos' => $videos]);
    }

    public function publishVideo($item_id)
    {
        $this->authorize('publish videos');
        try {
            DB::beginTransaction();
            $video = Video::find($item_id);
            if ($video === null) {
                session()->flash('error', 'Vidéo introuvable');

                return;
            }
            $video->is_published = true;
            $video->save();
            // envoyer un mail de notification
            $users = User::permission('receive event notifications')->get();
            // foreach ($users as $user) {
            //     Mail::to($user->email)->send(new EventCreated($video));
            // }
            // ajouter un audit
            AuditService::log("PUBLICATION D'UNE VIDÉO", null, null, 'Vidéo publiée : ' . $video->id);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Publication', 'message' => 'Vidéo publiée avec succès']);
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Publication | Erreur lors de la publication de la vidéo | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishVideo($item_id)
    {
        $this->authorize('unpublish videos');
        try {
            DB::beginTransaction();
            $video = Video::find($item_id);
            if ($video === null) {
                session()->flash('error', 'Vidéo introuvable');

                return;
            }
            $video->is_published = false;
            $video->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UNE VIDÉO", null, null, 'Vidéo desactivée : ' . $video->id);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Desactivation', 'message' => 'Vidéo desactivée avec succès']);
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Désactivation | Erreur lors de la désactivation de la vidéo | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }
}
