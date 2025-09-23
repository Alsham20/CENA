<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faq extends Model
{
    use HasFactory;

        protected $fillable = [
        'question',
        'answer',
        'category_id',
        'is_active',
        'position',
        'author_id',
        'order',
    ];

    public function categories(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
}
