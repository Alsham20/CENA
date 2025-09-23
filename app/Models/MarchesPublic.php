<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MarchesPublic extends Model
{
    use HasFactory;

        protected $guarded = [];

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author');
    }
}
