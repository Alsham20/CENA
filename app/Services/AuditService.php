<?php

namespace App\Services;

use App\Models\AuditService as Audit;
use App\Models\ErrorLog;
use App\Models\User;

class AuditService
{
    public static function log($event, $old_value, $new_value, $description = null, $user = null)
    {
        $user = $user ?? User::find(auth()->user()->id);
        Audit::create([
            'user_id' => $user->id,
            'event' => $event,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'description' => $description,
            'old_values' => $old_value,
            'new_values' => $new_value,
            'role' => json_encode($user->sroles()->pluck('name')->toArray()),

        ]);
    }

    public static function logAnonyme($event, $old_value, $new_value, $description = null)
    {
        Audit::create([
            'event' => $event,
            'description' => $description,
            'old_values' => $old_value,
            'new_values' => $new_value,
            'user_id' => 'anonyme',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'role' => 'anonyme',
        ]);
    }

    public static function logError($message, $stack, $username = 'anonyme')
    {
        ErrorLog::create([
            'user_id' => auth()->user()->id ?? $username,
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'message' => $message,
            'stack' => $stack,
        ]);
    }
}
