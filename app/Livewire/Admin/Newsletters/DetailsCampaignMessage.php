<?php

namespace App\Livewire\Admin\Newsletters;

use App\Models\NewsletterAbonne;
use App\Services\AuditService;
use Livewire\Component;
use Livewire\WithPagination;

class DetailsCampaignMessage extends Component
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

    public $messageId;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function mount($id)
    {
        $this->authorize('view campaigns');
        AuditService::log('DETAILS D\'UNE CAMPAGNE', null, null, 'Liste de diffusion de la campagne');
        $this->messageId = $id;
    }

    public function render()
    {
        if ($this->search == '') {
            $campaignDetails = NewsletterAbonne::where('message_id', $this->messageId)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = NewsletterAbonne::where('message_id', $this->messageId);
            foreach ($terms as $term) {
                $query->whereHas('follower', function ($q) use ($term) {
                    $q->where('email', 'LIKE', "%{$term}%")
                        ->orWhere('lastname', 'LIKE', "%{$term}%")
                        ->orWhere('firstname', 'LIKE', "%{$term}%");
                });
            }
            $campaignDetails = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->status != '') {
            $campaignDetails->where('status', $this->status);
        }
        $campaignDetails = $campaignDetails->paginate($this->perPage);

        return view('livewire.admin.newsletters.details-campaign-message', ['campaignDetails' => $campaignDetails]);
    }
}
