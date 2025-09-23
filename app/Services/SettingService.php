<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public static function get($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }

        return null;
    }

    public static function set($key, $value)
    {
        $setting = Setting::where('key', $key)->first();
        if (! $setting) {
            $setting = new Setting;
            $setting->key = $key;
        }
        $setting->value = $value;
        $setting->save();
    }
}
