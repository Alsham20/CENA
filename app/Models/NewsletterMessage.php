<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listDiffusion()
    {
        return $this->hasMany(NewsletterAbonne::class, 'message_id', 'id');
    }
}
