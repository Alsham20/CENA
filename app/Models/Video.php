<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'video_description', 'author', 'category', 'video_path', 'activity', 'date_video'];

        public function categories(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }


        public function activities(): HasOne
    {
        return $this->hasOne(Activity::class, 'id', 'activity');
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author');
    }
}
