<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Services\AuditService;
use Livewire\Attributes\Url;
use Livewire\Component;

class Details extends Component
{
    #[Url(as: 'ude')]
    public $user_id;

    public User $user;

    public function mount($user_id = null)
    {
        if (auth()->user()->id != $user_id) {

            $this->authorize('view users');
        }

        $this->user_id = $user_id;
        $user = User::find($this->user_id);
        if ($user === null) {
            // TODO : afficher message d'erreur
            abort(404);
        }
        $this->user = $user;

        // TODO : Ajouter un audit
        AuditService::log("DETAILS D'UN UTILISATEUR", null, null, 'Consultation du profil de l\'utilisateur : '.'#@'.$this->user->id.' | '.$this->user->email);
    }

    public function render()
    {

        return view('livewire.admin.users.details');
    }
}
