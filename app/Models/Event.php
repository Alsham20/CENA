<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $table = 'evenements';

    protected $fillable = ['event_name', 'place', 'event_description', 'event_date', 'event_start', 'event_end', 'category', 'poster', 'slug', 'author'];

    public function categories(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function image(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'poster');
    }
}
