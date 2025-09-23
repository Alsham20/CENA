<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;

class Add extends Component
{
    public $key;

    public $value;

    public $label;

    public $type;

    public $is_active;

    public $is_editable;

    public $types = [];

    public function store()
    {
        $validated = $this->validate([
            'key' => 'required|min:3',
            'value' => 'required|min:3',
            'label' => 'required|min:3',
            'type' => 'required|in:'.implode(',', $this->types),
            'is_active' => 'required',
            'is_editable' => 'required',
        ]);
        $setting = Setting::create($validated);
        session()->flash('status', 'Post successfully updated.');
        $this->reset(['key', 'value', 'label', 'type', 'is_active', 'is_editable']);

    }

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {

        return view('livewire.admin.settings.add');
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
