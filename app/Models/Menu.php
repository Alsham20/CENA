<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'new_tab',
        'parent_id',
        'position',
        'primary_title',
        'secondary_title',
        'permission',
        'icon',
        'menu_emplacement_id',
    ];

    const POSITIONS = [
        'header' => 1,
        'footer' => 2,

    ];

    public function parent(): HasOne
    {

        return $this->hasOne(Menu::class, 'id', 'parent_id');
    }

    public function emplacement(): HasOne
    {

        return $this->hasOne(MenuEmplacement::class, 'id', 'menu_emplacement_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
