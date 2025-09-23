<?php

namespace App\Livewire\Admin\Newsletters;

use App\Models\Category;
use App\Models\Newsletter;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Follower extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public $confirm_delete;

    public $categorie;

    public $categories = [];

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
        $this->authorize('list followers');
        AuditService::log('AFFICHAGE DES ABONNES', null, null, 'Liste des abonnés');
        $this->categories = Category::where('type', 'Abonne')->get();
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete followers');
        try {
            DB::beginTransaction();
            $follower = Newsletter::find($id);
            if ($follower === null) {
                session()->flash('error', 'Abonné introuvable');

                return;
            }
            $follower->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN ABONNE", null, null, 'Abonné supprimé : '.$follower->email);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('follower-deleted');
            session()->flash('success', 'Abonné supprimé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression des abonnés');
            AuditService::logError('Suppression | Erreur lors de la suppression des abonnés | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    #[On('unfollow')]
    public function unfollow($id)
    {
        $this->authorize('unfollow followers');
        try {
            DB::beginTransaction();
            $follower = Newsletter::find($id);
            if ($follower === null) {
                session()->flash('error', 'Abonné introuvable');

                return;
            }
            $follower->is_active = false;
            $follower->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UN ABONNE", null, null, 'Abonné désactivé : '.$follower->email);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('follower-unfollowed');
            session()->flash('success', 'Abonné désactivé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-unfollowed');
            session()->flash('error', 'Erreur lors de la désactivation des abonnés');
            AuditService::logError('Suppression | Erreur lors de la désactivation des abonnés | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    #[On('follow')]
    public function follow($id)
    {
        $this->authorize('follow followers');
        try {
            DB::beginTransaction();
            $follower = Newsletter::find($id);
            if ($follower === null) {
                session()->flash('error', 'Abonné introuvable');

                return;
            }
            $follower->is_active = true;
            $follower->save();
            // ajouter un audit
            AuditService::log("ACTIVATION D'UN ABONNE", null, null, 'Abonné activé : '.$follower->email);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('follower-followed');
            session()->flash('success', 'Abonné activé avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-followed');
            session()->flash('error', 'Erreur lors de l\'activation des abonnés');
            AuditService::logError('Suppression | Erreur lors de l\'activation des abonnés | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function render()
    {

        if ($this->search == '') {
            $followers = Newsletter::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = Newsletter::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('lastname', 'LIKE', "%{$term}%")
                        ->orWhere('firstname', 'LIKE', "%{$term}%")
                        ->orWhere('email', 'LIKE', "%{$term}%");
                });
            }
            $followers = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->categorie != '') {
            if ($this->categorie == -1) {
                $followers->whereNull('categorie_abonne_id');
            } else {
                $followers->where('categorie_abonne_id', $this->categorie);
            }
        }

        if ($this->status != '') {
            $followers->where('is_active', $this->status);
        }

        $followers = $followers->paginate($this->perPage);

        return view('livewire.admin.newsletters.follower', ['followers' => $followers]);

    }
}
