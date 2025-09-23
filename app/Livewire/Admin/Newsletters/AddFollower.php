<?php

namespace App\Livewire\Admin\Newsletters;

use App\Models\Category;
use App\Models\NewsLetter;
use App\Services\AuditService;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Shuchkin\SimpleXLSX;

class AddFollower extends Component
{
    use WithFileUploads;

    public $attached_file_;

    public $categorie;

    public $categories = [];

    public function mount()
    {

        // $this->authorize('create followers');
        $this->categories = Category::where('type', 'Abonne')->get();
    }

    public function store()
    {
        $this->authorize('create followers');
        $this->author = auth()->user()->id;
        $validated = $this->validate([
            'categorie' => 'required|integer',
            'attached_file_' => 'required|file|mimes:xlsx',
        ]);
        try {
            DB::beginTransaction();

            $fileupload = FileService::uploadOtherFile($this->attached_file_, 'abonnes/');
            // dd($fileupload);
            if ($this->categorie == -1) {
                $cat = null;
            } else {
                $cat = $this->categorie;
            }
            if ($xlsx = SimpleXLSX::parse(public_path('storage'.$fileupload['path'].$fileupload['name']))) {
                foreach ($xlsx->rows() as $key => $value) {
                    if ($key == 0) {
                        continue;
                    }
                    if ($this->isValidEmail(trim($value[0])) && ! NewsLetter::where('email', $value[0])->exists()) {

                        NewsLetter::create(['email' => trim($value[0]), 'lastname' => trim($value[1]), 'firstname' => trim($value[2]), 'is_active' => 1, 'categorie_abonne_id' => $cat]);
                    }
                }
            }

            $this->reset(['attached_file_']);
            $this->dispatch('resetEditors');
            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Enregistrement', 'message' => 'Abonnés enregistrés avec succès.']);
            AuditService::log("CHARGEMENT D'ABONNES", null, null, "Chargement d'abonnés");
            DB::commit();
            $this->dispatch('new-marche-public');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => 'Une erreur est survenue.']);
            AuditService::logError("Creation | Erreur lors de l'ajout des abonnés | ".$th->getMessage(), $th->getTraceAsString(), auth()->user()->email);
        }
    }

    public function render()
    {
        return view('livewire.admin.newsletters.add-follower');
    }

    public function isValidEmail($email)
    {
        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'email']
        );

        return ! $validator->fails();
    }
}
