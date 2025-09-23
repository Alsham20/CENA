<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditService extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'event', 'ip_address', 'user_agent', 'url', 'description', 'old_values', 'new_values', 'role'];

    public function user()
    {
        return User::find($this->user_id)->first();
    }

    public function decodeValues($value)
    {
        try {

            return json_decode($value, true) ? json_decode($value, true) : [$value];
        } catch (\Throwable $th) {

            return [$value];
        }
    }
}
