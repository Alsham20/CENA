<?php

namespace App\Livewire\Admin\Audits;

use App\Models\AuditService;
use Livewire\Component;

class Show extends Component
{
    public $audit_id;

    public function mount($audit_id)
    {
        $this->authorize('view audits');
        $this->audit_id = $audit_id;

    }

    public function render()
    {
        $audit = AuditService::find($this->audit_id);
        if ($audit === null) {
            abort(404);
        }

        return view('livewire.admin.audits.show', [
            'audit' => $audit,
        ]);
    }
}
