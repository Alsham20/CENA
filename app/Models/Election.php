<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Election extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function resultats()
    {
        return $this->hasMany(Resultat::class, 'election_id');
    }

    public function categories(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }
}
