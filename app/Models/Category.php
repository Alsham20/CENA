<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [

        'label',
        'type',
        'parent',
        'author',

    ];

    public function parents(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'parent');
    }
}
