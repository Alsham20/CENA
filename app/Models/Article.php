<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    use HasFactory;

        protected $fillable = ['title', 'content', 'author_id', 'category', 'poster', 'resume', 'slug', 'content_keywords', 'content_description', 'tags', 'is_featured', 'is_private', 'date_article'];

    public function categories(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'poster');
    }
}
