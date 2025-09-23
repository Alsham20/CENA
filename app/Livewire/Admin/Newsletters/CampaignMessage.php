<?php

namespace App\Livewire\Admin\Newsletters;

use App\Jobs\SendCampaignEmails;
use App\Models\Category;
use App\Models\NewsLetter;
use App\Models\NewsletterAbonne;
use App\Models\NewsletterMessage;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CampaignMessage extends Component
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

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('delete campaigns');
        try {
            DB::beginTransaction();
            $campaign = NewsletterMessage::find($id);

            if ($campaign === null) {
                session()->flash('error', 'Campagne introuvable');

                return;
            }
            NewsletterAbonne::where('message_id', $campaign->id)->delete();
            $campaign->delete();
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE CAMPAGNE", null, null, 'Campagne supprimée : '.$campaign->name);
            DB::commit();
            $this->confirm_delete = null;
            $this->dispatch('campaign-deleted');
            session()->flash('success', 'Campagne supprimée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            session()->flash('error', 'Erreur lors de la suppression des campagnes');
            AuditService::logError('Suppression | Erreur lors de la suppression des campagnes | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }

    }

    public function publishCampaign($id)
    {
        $this->authorize('publish campaigns');
        try {
            DB::beginTransaction();
            $campaign = NewsletterMessage::find($id);
            if ($campaign === null) {
                session()->flash('error', 'Campagne introuvable');

                return;
            }
            $list = NewsletterAbonne::where('message_id', $campaign->id)->pluck('abonne_id')->toArray();
            $followers = NewsLetter::whereIn('id', $list)->get();
            SendCampaignEmails::dispatch($followers, $campaign);

            $campaign->status = 1;
            $campaign->save();
            // ajouter un audit
            AuditService::log("PUBLICATION D'UNE CAMPAGNE", null, null, 'Campagne publiée : '.$campaign->name);
            DB::commit();
            session()->flash('success', 'Campagne publiée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la publication de la campagne');
            AuditService::logError('Publication | Erreur lors de la publication de la campagne | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishCampaign($id)
    {
        $this->authorize('unpublish campaigns');
        try {
            DB::beginTransaction();
            $campaign = NewsletterMessage::find($id);
            if ($campaign === null) {
                session()->flash('error', 'Campagne introuvable');

                return;
            }
            $campaign->status = 0;
            $campaign->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UNE CAMPAGNE", null, null, 'Campagne désactivée : '.$campaign->name);
            DB::commit();
            session()->flash('success', 'Campagne désactivée avec succès');
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la désactivation de la campagne');
            AuditService::logError('Desactivation | Erreur lors de la desactivation de la camapgne | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function mount()
    {
        $this->authorize('list campaigns');
        AuditService::log('AFFICHAGE DES CAMPAGNES', null, null, 'Liste des campagnes');
        $this->categories = Category::where('type', 'Abonne')->get();
    }

    public function render()
    {
        if ($this->search == '') {
            $campaigns = NewsletterMessage::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = NewsletterMessage::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'LIKE', "%{$term}%")
                        ->orWhere('object', 'LIKE', "%{$term}%");
                });
            }
            $campaigns = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->categorie != '') {
            if ($this->categorie == -1) {
                $campaigns->whereNull('categorie_abonne_id');
            } else {
                $campaigns->where('categorie_abonne_id', $this->categorie);
            }
        }

        if ($this->status != '') {
            $campaigns->where('status', $this->status);
        }

        $campaigns = $campaigns->paginate($this->perPage);

        return view('livewire.admin.newsletters.campaign-message', ['campaigns' => $campaigns]);
    }
}
