<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SidebarComponent extends Component
{
    public $activeSection = 'home';

    public function setActiveSection($section)
    {
        $this->activeSection = $section;
    }

    public function render()
    {
        return view('livewire.admin.sidebar-component');
    }
}
