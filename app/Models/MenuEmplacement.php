<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuEmplacement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'menu_emplacement_id', 'id');
    }
}
