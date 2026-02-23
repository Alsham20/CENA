<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function election()
    {
        return $this->hasOne(Election::class, 'id', 'election_id');
    }
}
