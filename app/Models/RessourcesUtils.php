<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessourcesUtils extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'documentations';

    public function categorie()
    {
        return $this->hasOne(Category::class, 'id', 'categorie_id');
    }
}
