<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserCreateComponent extends Component
{
    public $roles_;

    public $lastname;

    public $firstname;

    public $email;

    public $phone;

    public $password;

    public $roles = [];

    public $send_activation_mail = false;

    public $set_default_password;

    public $save_and_leave = false;

    public function store()
    {
        $this->authorize('create users');

        $validated = $this->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'phone' => ['required', 'string', Rule::unique('users')->whereNull('deleted_at')],
            'password' => [
                'nullable',
                'min:12',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[^a-zA-Z0-9]/',
            ],
            'roles.*' => 'required|exists:roles,name',
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un caractère spécial.',
            'password.nullable' => 'Si un mot de passe est fourni, il doit répondre aux critères spécifiés.',
            'email.unique' => 'L\'email fourni est déjà utilisé.',
            'phone.unique' => 'Le numéro de téléphone fourni est déjà utilisé.',
            'roles.*.required' => 'Chaque rôle est requis.',
            'roles.*.exists' => 'Le rôle spécifié est invalide.',
        ]);


        try {

            DB::beginTransaction();

            // si l'utilisateur a la permission d'activer le compte, on le creer avec un mot de passe par defaut ou le mot de passe saisi
            $data = [
                'lastname' => $this->lastname,
                'firstname' => $this->firstname,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => $this->password ? Hash::make($this->password) : Hash::make(uniqid()),
                'must_change_password' => $this->set_default_password ? false : true,
            ];
            $user = User::create($data);
            $user->assignRole($this->roles);
            $this->reset(['lastname', 'firstname', 'phone', 'email', 'password', 'roles']);

            // ajouter un audit pour l'action de creation d'utilisateur
            AuditService::log("CREATION D'UN UTILISATEUR", null, json_encode($user), "Creation d'utilisateur ".$user->email);
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Utilisateur Créé', 'message' => 'Utilisateur créé avec succès.']);

            DB::commit();
            if ($this->send_activation_mail) {
                $user->sendPasswordActivationMail();
            }

        } catch (\Throwable $th) {

            DB::rollBack();
            // ajouter un audit pour l'action d'echec de creation d'utilisateur
            AuditService::logError("ECHEC DE LA CREATION D'UN UTILISATEUR", $th->getMessage(), null, null);
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
        }

    }

    public function mount()
    {
        // verifier si l'utilisateur a les permissions pour creer un user
        $this->authorize('create users');

        // ajouter un audit pour l'action d'affichage du formulaire de creation d'utilisateur
        AuditService::log("AFFICHAGE DU FORMULAIRE DE CREATION D'UTILISATEUR", null, null, null);

        $this->roles_ = Role::all();
    }

    public function render()
    {
        return view('livewire.admin.user-create-component');
    }
}
