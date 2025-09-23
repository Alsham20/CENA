<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use App\Services\AuditService;
use Livewire\Component;
use Livewire\WithPagination;

class Settings extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $orderBy = 'id';

    public $orderAsc = false;

    public $confirm_delete;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function delete($setting_id)
    {
        $this->authorize('delete settings');
        try {
            // dd($setting_id);
            $setting = Setting::find($setting_id);
            if ($setting === null) {
                $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Parametre introuvable']);

                return;
            }

            $this->dispatch('setting-deleted');
            $setting->delete();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Parametre Supprime', 'message' => 'Parametre supprime avec succès']);
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UN PARAMETRE", null, null, 'Parametre supprime : '.$setting->label);
            $this->confirm_delete = null;

        } catch (\Throwable $th) {
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => $th->getMessage()]);
            AuditService::log("ERREUR D'UN PARAMETRE", null, null, 'Parametre supprime : '.$setting->label);
        }

    }

    public function mount()
    {
        $this->authorize('list settings');
        AuditService::log('AFFICHAGE DES PARAMETRES', null, null, 'Liste des parametres');
    }

    public function render()
    {
        if ($this->search !== '') {
            $settings = Setting::whereIsEditable(1)->where('label', 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $settings = Setting::whereIsEditable(1)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.settings.settings', [
            'settings' => $settings,
        ]);
    }
}
