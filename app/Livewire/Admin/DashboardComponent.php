<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use Livewire\Component;

class DashboardComponent extends Component
{
    public $user;

    public $article;

    public $page;

    public $composante;

    public function mount()
    {
        $this->user = User::where('is_active', 1)->count();
        $this->article = Article::where('is_published', 1)->where('is_deleted', 0)->count();
        // $this->composante = Composante::count();
        $this->page = Page::where('is_published', 1)->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-component');
    }
}
