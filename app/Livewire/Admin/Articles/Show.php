<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use Livewire\Component;

class Show extends Component
{
    public $article_id;

    public function mount($article_id)
    {
        $this->authorize('view articles');
        $this->article_id = $article_id;

    }

    public function render()
    {
        $article = Article::find($this->article_id);
        if ($article === null) {
            abort(404);
        }

        return view('livewire.admin.articles.show', [
            'article' => $article,
        ]);
    }
}
