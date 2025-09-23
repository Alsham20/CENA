<?php

namespace App\Livewire\Admin\Audits;

use App\Models\AuditService;
use App\Services\AuditService as sAuditService;
use Livewire\Component;
use Livewire\WithPagination;

class Audits extends Component
{
    use WithPagination;

    // pagination
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = false;

    public function mount()
    {
        sAuditService::log('AFFICHAGE DES LOGS D\'AUDITS', null, null, 'Liste des logs audits');

    }

    public function render()
    {
        if ($this->search == '') {
            $audits = AuditService::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        } else {
            $terms = explode(' ', $this->search);
            $query = AuditService::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('event', 'LIKE', "%{$term}%")
                        ->orWhere('url', 'LIKE', "%{$term}%")
                        ->orWhere('ip_address', 'LIKE', "%{$term}%")
                        ->orWhere('tags', 'LIKE', "%{$term}%")
                        ->orWhere('user_agent', 'LIKE', "%{$term}%")
                        ->orWhere('auditable_type', 'LIKE', "%{$term}%");
                });
            }
            $audits = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        }

        return view('livewire.admin.audits.audits', ['audits' => $audits]);
    }
}
