<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMail extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mail', 'message', 'object', 'phone', 'sent_at', 'attachments', 'recipients', 'cc', 'bcc'];
}
