<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Url;
use Livewire\Component;

class BaseComponent extends Component
{
    #[Url(as: 's')]
    public $activeSection = 'dashboard';

    #[Url(as: 'ude')]
    public $param;

    protected $listeners = ['sectionUpdated' => 'updateSection'];

    public function updateSection($value)
    {
        $this->activeSection = $value;
        // session(['menuactive' => $value]);
    }

    /*public function mount(){
        $this->activeSection = (session('menuactive') !== null) ? session('menuactive') : 'dashboard';
    }*/

    public function setActiveSection($section, $param = null)
    {

        if ($param !== null) {
            $this->param = $param;
        }
        $this->activeSection = $section;

    }

    public function render()
    {
        return view('livewire.admin.base-component');
    }
}
