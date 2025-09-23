<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Category;
use App\Models\Faq;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Faqs extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $orderBy = 'id';

    public $orderAsc = false;

    public $confirm_delete;

    public $categories = [];

    public $status;

    public $categorie;

    public function sortBy($name)
    {
        if ($this->orderBy == $name) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $name;
    }

    public function mount()
    {
        $this->authorize('list faqs');
        $this->categories = Category::where('type', 'Abonne')->get();
        AuditService::log('AFFICHAGE DES FAQS', null, null, 'Liste des faqs');

    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[On('delete')]
    public function delete($faq_id)
    {
        $this->authorize('delete faqs');
        try {
            // dd($faq_id);
            DB::beginTransaction();
            $faq = Faq::find($faq_id);
            if ($faq === null) {
                $this->dispatch('notification', ['type' => 'error', 'title' => 'Erreur', 'message' => 'FAQ introuvable']);

                return;
            }

            $this->dispatch('faq-deleted');
            $faq->delete();
            $this->dispatch('notification', ['type' => 'success', 'title' => 'FAQ Supprime', 'message' => 'FAQ supprime avec succès']);
            // ajouter un audit
            AuditService::log("SUPPRESSION D'UNE QUESTION", null, null, 'FAQ supprime : '.$faq->question);
            $this->confirm_delete = null;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('error-deleted');
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => $th->getMessage()]);
            AuditService::log("ERREUR D'UNE QUESTION", null, null, 'FAQ supprime : '.$faq->question);
        }

    }

    public function publishArticle($faq_id)
    {
        
        $this->authorize('publish faqs');
        try {
            DB::beginTransaction();
            $faq = Faq::find($faq_id);
            if ($faq === null) {
                $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'FAQ introuvable']);

                return; 
            }
            //dd($faq);
            $faq->is_active = true;
            $faq->save();
            // ajouter un audit
            AuditService::log("PUBLICATION D'UNE QUESTION", null, null, 'FAQ publie : '.$faq->question);
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'FAQ Publie', 'message' => 'FAQ publie avec succès']);
            DB::commit();
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'FAQ Erreur', 'message' => $th->getMessage()]);
            AuditService::logError('Publication | Erreur lors de la publication de la faq | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function unpublishArticle($faq_id)
    {
        $this->authorize('unpublish faqs');
        try {
            DB::beginTransaction();
            $faq = Faq::find($faq_id);
            if ($faq === null) {
                $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'FAQ introuvable']);

                return;
            }
            $faq->is_active = false;
            $faq->save();
            // ajouter un audit
            AuditService::log("DESACTIVATION D'UNE QUESTION", null, null, 'Article desactive : '.$faq->question);
            DB::commit();
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'FAQ Publie', 'message' => 'FAQ publie avec succès']);
            $this->resetPage();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Erreur lors de la desactivation de la faq']);
            AuditService::logError('Desactivation | Erreur lors de la desactivation de l\'faq | '.$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {

        if ($this->search == '') {
            $faqs = Faq::orderBy('order', 'asc')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        } else {
            $terms = explode(' ', $this->search);
            $query = Faq::query();
            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('question', 'LIKE', "%{$term}%")
                        ->orWhere('answer', 'LIKE', "%{$term}%");
                });
            }
            $faqs = $query->orderBy('order', 'asc')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        if ($this->categorie != '') {
            $faqs->where('category_id', (int) $this->categorie);
        }

        if ($this->status != '') {
            $faqs->where('is_active', (int) $this->status);
        }
        $faqs = $faqs->paginate($this->perPage);

        return view('livewire.admin.faqs.faqs', ['faqs' => $faqs]);
    }
}
