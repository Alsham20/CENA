<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'firstname', 'lastname', 'categorie_abonne_id'];

    public function categorie()
    {
        return $this->hasOne(Category::class, 'id', 'categorie_abonne_id');
    }
}
