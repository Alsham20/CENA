<?php

namespace App\Livewire\Admin\Events;

use App\Mail\EventCreated;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $category = -1;

    public $categories;

    public $type;

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
        $this->authorize('list events');
        $this->categories = Category::where('type', 'Event')->get();
        AuditService::log('AFFICHAGE DES EVENEMENTS', null, null, 'Liste des évènements');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete events');
        try {
            DB::beginTransaction();
            $event = Event::find($id);
            if ($event === null) {
                session()->flash('error', 'Evènement introuvable');

                return;
            }
            $event->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN EVENEMENT", null, null, 'Evènement supprime : ' . $event->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('event-deleted');
            session()->flash('success', 'Evènement supprimé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('event-error');
            session()->flash('error', 'Erreur lors de la suppression des évènements');
            AuditService::logError('Suppression | Erreur lors de la suppression de l\'évènement | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        if ($this->search == '') {
            $events = Event::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = Event::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('event_name', 'LIKE', "%{$term}%")
                        ->orWhere('place', 'LIKE', "%{$term}%")
                        ->orWhere('event_description', 'LIKE', "%{$term}%")
                        ->orWhere('event_start', 'LIKE', "%{$term}%")
                        ->orWhere('event_end', 'LIKE', "%{$term}%");
                });
            }
            $events = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->category != -1) {
            $events->where('category', (int) $this->category);
        }

        if ($this->status != '') {
            $events->where('is_published', $this->status);
        }

        $events = $events->paginate($this->perPage);

        return view('livewire.admin.events.events', ['events' => $events]);
    }

    public function publishEvent($item_id)
    {
        $this->authorize('publish events');
        try {
            DB::beginTransaction();
            $article = Event::find($item_id);
            if ($article === null) {
                session()->flash('error', 'Article introuvable');

                return;
            }
            $article->is_published = true;
            $article->save();
            // envoyer un mail de notification
            $users = User::permission('receive event notifications')->get();
            // foreach ($users as $user) {
            //     Mail::to($user->email)->send(new EventCreated($article));
            // }
            // ajouter un audit
            AuditService::log("PUBLICATION D'UN EVENEMENT", null, null, 'Article publie : ' . $article->id);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Publication', 'message' => 'Evènement publie avec succès']);
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Publication | Erreur lors de la publication de l\'evènement | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishEvent($item_id)
    {
        $this->authorize('unpublish events');
        try {
            DB::beginTransaction();
            $article = Event::find($item_id);
            if ($article === null) {
                session()->flash('error', 'Evènement introuvable');

                return;
            }
            $article->is_published = false;
            $article->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UN EVENEMENT", null, null, 'Evènement desactive : ' . $article->id);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Desactivation', 'message' => 'Evènement desactive avec succès']);
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError('Desactivation | Erreur lors de la desactivation de l\'evènement | ' . $th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }
}
