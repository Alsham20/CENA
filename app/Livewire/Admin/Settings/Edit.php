<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $key;

    public $value;

    public $label;

    public $type;

    public $is_active;

    public $is_editable;

    public $types = [];

    public $setting_id;

    public $setting;

    public function store()
    {
        $validated = $this->validate([
            'key' => 'required|min:3',
            'value' => 'required|min:1',
            'label' => 'required|min:3',
            'type' => 'required|in:'.implode(',', $this->types),
            'is_active' => 'required',
            'is_editable' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $setting = Setting::updateOrCreate(['id' => $this->setting_id], $validated);

            $this->dispatch('notification', ['icon' => 'success', 'title' => 'Parametre Modifie', 'message' => 'Parametre modifie avec succès']);
            // $this->reset(['key', 'value', 'label', 'type', 'is_active', 'is_editable']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->dispatch('notification', ['icon' => 'error', 'title' => 'Erreur', 'message' => $th->getMessage()]);

        }

    }

    public function mount($setting_id)
    {
        $this->authorize('edit settings');
        $setting = Setting::find($setting_id);
        $this->setting = $setting;
        if ($setting === null) {
            abort(404);
        }

        $this->key = $setting->key;
        $this->value = $setting->value;
        $this->label = $setting->label;
        $this->type = $setting->type;
        $this->is_active = $setting->is_active;
        $this->is_editable = $setting->is_editable;

        $this->setting_id = $setting->id;

        $this->loadData();
    }

    public function render()
    {

        return view('livewire.admin.settings.edit');
    }

    public function loadData()
    {
        $this->types = [
            'string',
            'integer',
            'boolean',
            'text',
            'password',
        ];

        $this->is_active = true;
        $this->is_editable = true;
        // $this->type = 'string';
    }
}
