<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterAbonne extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campagne()
    {
        return $this->hasOne(NewsletterMessage::class, 'id', 'message_id');
    }

    public function follower()
    {
        return $this->hasOne(NewsLetter::class, 'id', 'abonne_id');
    }
}
