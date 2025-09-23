<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'type', 'base_url', 'thumbnail', 'size', 'author_id'];

    public function getUrl()
    {
        return $this->base_url . $this->path . '/' . $this->name;
    }

    public function getUrlThumbnail()
    {
        return $this->base_url . $this->path . '/' . $this->thumbnail;
    }
}
