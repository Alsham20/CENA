<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Url;
use Livewire\Component;

class Password extends Component
{
    #[Url(as: 'ude')]
    public $user_id;

    public User $user;

    public $password;

    public $password_confirmation;

    public $old_password;

    public $roles = [];

    public $send_activation_mail = false;

    public function mount($user_id = null)
    {
        if (auth()->user()->id != $user_id) {

            $this->authorize('edit users');
        }

        $this->user_id = $user_id;
        $user = User::find($this->user_id);
        if ($user === null) {
            // TODO : afficher message d'erreur
            abort(404);
        }
        $this->user = $user;

        // TODO : Ajouter un audit
        AuditService::log("MODIFICATION DU MOT DE PASSE D'UN UTILISATEUR", null, null, 'Consultation de la modification du mot de passe de l\'utilisateur : '.'#@'.$this->user->id.' | '.$this->user->email);
    }

    public function updatePassword()
    {
        if (auth()->user()->id != $this->user_id) {

            $this->authorize('edit users');
        }
        $validated = $this->validate([
            'password' => [
                'required',
                'min:12',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[^a-zA-Z0-9]/',
            ],
            'old_password' => 'required',
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un caractère spécial.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);


        $email = auth()->user()->email;
        try {

            DB::beginTransaction();
            if (Hash::check($this->old_password, $this->user->password)) {
                $this->user->password = Hash::make($this->password);
                $this->user->save();
            } else {
                $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Mot de Passe actuel incorrect.']);

                return;
            }
            // ajouter un audit pour l'action de modification d'utilisateur
            AuditService::log("MODIFICATION DU MOT DE PASSE D'UN UTILISATEUR", null, json_encode($this->user->toArray()), "Modification du mot de passe de l'utilisateur : '#@' ".$this->user->id.' | '.$this->user->email);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Mot de Passe Modifier', 'message' => 'Mot de Passe modifier avec succès.']);
            $this->reset(['password', 'password_confirmation', 'old_password']);
            DB::commit();
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect(route('app_login'));
        } catch (\Throwable $th) {
            DB::rollBack();
            // ajouter un audit pour l'action d'echec de creation d'utilisateur
            AuditService::logError('ECHEC DE LA MODIFICATION DU MOT DE PASSE D\'UN UTILISATEUR | '.$th->getMessage(), $th->getTraceAsString(), $email);

            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue durant la modification du mot de passe.']);
        }
    }

    public function render()
    {

        return view('livewire.admin.users.password');
    }
}
