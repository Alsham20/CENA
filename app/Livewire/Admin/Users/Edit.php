<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    #[Url(as: 'ude')]
    public $user_id;

    public User $user;

    public $roles_;

    public $lastname;

    public $firstname;

    public $email;

    public $phone;

    public $roles = [];

    public $send_activation_mail = false;

    public $set_default_password;

    public $save_and_leave = false;

    public function store()
    {
        $this->authorize('edit users');

        $validated = $this->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|exists:users',
            'phone' => 'required|string|exists:users',
            'roles.*' => 'required|exists:roles,name',

        ]);

        try {

            DB::beginTransaction();

            // si l'utilisateur a la permission d'activer le compte, on le creer avec un mot de passe par defaut ou le mot de passe saisi
            $data = [
                'lastname' => $this->lastname,
                'firstname' => $this->firstname,
                'email' => $this->email,
                'phone' => $this->phone,
            ];
            $old = json_encode($this->user);
            $this->user->update($data);
            $this->user->syncRoles($this->roles);

            // ajouter un audit pour l'action de modification d'utilisateur
            AuditService::log("MODIFICATION D'UN UTILISATEUR", $old, json_encode($this->user->toArray()), "Modification d'utilisateur ".$this->user->email);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Utilisateur Modifier', 'message' => 'Utilisateur modifier avec succès.']);
            $this->reset(['lastname', 'firstname', 'phone', 'email', 'roles']);
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            // ajouter un audit pour l'action d'echec de creation d'utilisateur
            AuditService::logError('ECHEC DE LA CREATION D\'UN UTILISATEUR | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);

            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
        }

    }

    public function mount($user_id = null)
    {
        // verifier si l'utilisateur a les permissions pour creer un user
        $this->authorize('edit users');
        $this->user_id = $user_id;
        $user = User::find($this->user_id);
        if ($user === null) {
            // TODO : afficher message d'erreur
            abort(404);
        }
        $this->user = $user;
        $this->roles = $user->roles->pluck('name')->toArray();
        $this->lastname = $user->lastname;
        $this->firstname = $user->firstname;
        $this->email = $user->email;
        $this->phone = $user->phone;
        // ajouter un audit pour l'action d'affichage du formulaire de creation d'utilisateur
        AuditService::log("AFFICHAGE DU FORMULAIRE DE MODIFICATION D'UN UTILISATEUR", null, null, null);

        $this->roles_ = Role::all();
        $this->dispatch('user-edit');
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
