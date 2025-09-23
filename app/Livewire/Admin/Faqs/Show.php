<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use Livewire\Component;

class Show extends Component
{
    public $faq_id;

    public function mount($faq_id)
    {
        $this->authorize('view faqs');
        $this->faq_id = $faq_id;

    }

    public function render()
    {
        $faq = Faq::find($this->faq_id);
        if ($faq === null) {
            abort(404);
        }

        return view('livewire.admin.faqs.show', [
            'faq' => $faq,
        ]);
    }
}
