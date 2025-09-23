<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Services\AuditService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersComponent extends Component
{
    use WithPagination;

    public $confirm_delete;

    // pagination

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public $roles = [];

    public $role;

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

    #[On('delete')]
    public function delete($user_id)
    {
        $this->authorize('delete users');

        try {
            $this->dispatch('CLOSE_MODAL');
            $user = User::find($user_id);
            if ($user === null) {
                session()->flash('error', 'Utilisateur introuvable');

                return;
            }

            // verifier si l'utilisateur est actif
            if ($user->is_active) {
                session()->flash('error', 'L\'utilisateur est actif et ne peut pas être supprime. Vous devez le suspendre');

                return;
            }
            $old_value = json_encode($user);
            $user->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UTILISATEUR", $old_value, null, 'Utilisateur supprime '.$user->email);
            $this->confirm_delete = null;

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Utilisateur Supprime', 'message' => 'Utilisateur supprime avec succès']);
            $this->resetPage();

        } catch (\Throwable $th) {
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Erreur lors de la suppression du compte']);
            AuditService::logError('Suppression | Erreur lors de la suppression du compte | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function updatingSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function suspend($user_id)
    {
        $this->authorize('suspend users');
        try {
            $this->dispatch('CLOSE_MODAL');
            $user = User::find($user_id);
            if ($user === null) {
                $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Utilisateur introuvable']);

                return;
            }
            $user->is_suspended = true;
            $user->is_active = false;
            $user->save();
            // ajouter un audit
            AuditService::log("SUSPENSION D'UTILISATEUR", null, null, 'Utilisateur suspendu '.$user->email);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Utilisateur suspendu', 'message' => 'Utilisateur suspendu avec succès']);
        } catch (\Throwable $th) {
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Erreur lors de la suspension du compte']);
            AuditService::logError('Suspension | Erreur lors de la suspension du compte | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function unsuspend($user_id)
    {

        $this->authorize('unsuspend users');
        try {
            $this->dispatch('CLOSE_MODAL');
            $user = User::find($user_id);
            if ($user === null) {
                $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Utilisateur introuvable']);

                return;
            }
            $user->is_suspended = false;
            $user->is_active = true;
            $user->save();
            // ajouter un audit
            AuditService::log("ACTIVATION D'UTILISATEUR", null, null, 'Utilisateur active '.$user->email);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Utilisateur active', 'message' => 'Utilisateur active avec succès']);
        } catch (\Throwable $th) {
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => "Erreur lors de l\'activation du compte"]);
            AuditService::logError('Activation | Erreur lors de l\'activation du compte | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function showCreateUserForm()
    {
        $this->dispatch('sectionUpdated', 'users_add');
    }

    public function mount()
    {
        $this->authorize('list users');
        $this->roles = Role::all();

    }

    public function render()
    {
        if ($this->search != '') {

            $users = User::where('firstname', 'like', '%'.$this->search.'%')
                ->orWhere('lastname', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orWhere('id', 'like', '%'.$this->search.'%')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

        } else {
            $users = User::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
            /*if (! empty($this->roles)) {
                $users = User::role($this->roles);
                $users = $users->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
            } else {
                $users = User::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
            }*/

        }

        if ($this->role != '') {
            $us = User::role($this->roles);
            $users->whereIn('id', $us->pluck('id'));
        }

        if ($this->status != '') {
            $users->where('is_active', $this->status);
        }

        $users = $users->paginate($this->perPage);

        return view('livewire.admin.users.users-component', ['users' => $users]);
    }
}
