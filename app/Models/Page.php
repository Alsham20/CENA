<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'author_id', 'category', 'poster', 'resume', 'slug', 'content_keywords', 'content_description', 'tags'];

    public function categories(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function poster_media(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'poster');
    }
}
